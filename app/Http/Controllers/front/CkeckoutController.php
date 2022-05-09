<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\CompraExitosa;
use App\Mail\OrderPaidOxxoPay;
use App\Mail\ReferenceOxxoPay;
use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\Coupon;
use App\Models\DatosEnvio;
use App\Models\Productos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Conekta\Conekta;
use Conekta\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CkeckoutController extends Controller
{
    protected $request;
    protected $compra;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->compra = new Compra();
    }

    public function checkout()
    {
        session_start();
        // Check session
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Chect cart
        if( !(isset($_SESSION['carrito'])) || !(isset($_SESSION['totalpagar'])) || sizeof($_SESSION['carrito'])==0 ){
            return redirect('/');
        }

        return view('front.checkout');
    }

    public function payWithMercadoPago(Request $request)
    {
        session_start();

        $payment_id = $request->get('payment_id');

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=" . config('services.mercadopago.token'));
        $response = json_decode($response);

        if ($response->status == "approved") {

            // Varibles
            $user     = Auth::user();
            $carrito  = $_SESSION['carrito'];

            $datos_envio = DatosEnvio::where('id_user', $user->id)->first();

            // Save order
            $this->compra->id_user     = $user->id;
            $this->compra->costo_envio = $_SESSION['gastoEnvio'];
            $this->compra->subtotal    = $_SESSION['subtotal'];
            $this->compra->preciototal = $_SESSION['totalpagar'];
            $this->compra->status      = "Pagado";
            $this->compra->method      = "MercadoPago";
            $this->compra->id_datosenvio = $datos_envio->id;
            $this->compra->chargeid    = $payment_id;
            $this->compra->save();

            /* Insertar Items */
            for ($i = 0; $i < sizeof($carrito); $i++) {

                $producto = Productos::find($carrito[$i]['producto_id']);
                $total = $producto->precio * $carrito[$i]['cantidad'];

                // Quitar del Stock
                $stock = (int) $producto->stock;
                $dismiss_quantity = (int) $carrito[$i]['cantidad'];

                $producto->stock = $stock - $dismiss_quantity;
                $producto->save();

                $compra_item = new CompraItem();
                $compra_item->compra_id   = $this->compra->id;
                $compra_item->id_producto = $carrito[$i]['producto_id'];
                $compra_item->cantidad    = $carrito[$i]['cantidad'];
                $compra_item->precio      = $producto->precio;
                $compra_item->total       = $total;
                $compra_item->save();
            }

            $this->sendOrderMail();

            // En caso de que todo OK.
            return redirect('/checkout')->with('statusPayMercadoPago', 'success');

        } else {
            // Pago no aprovado
            return redirect('/checkout')->with('statusPayMercadoPago', 'Status: ' . $response->status . '. Details: ' . $response->status_detail);
        }

    }

    public function payWithConekta(Request $request)
    {
        session_start();

        // Config conekta
        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setApiVersion('2.0.0');
        Conekta::setLocale('es');

        if (!Auth::check()) {
            return response()->json(['ok' => false, 'message' => 'No hay sessión iniciada']);
        }

        // User
        $user = Auth::user();

        // Varibles
        $token    = $request->token_id;
        $id_envio = $request->id_envio;
        $carrito  = $_SESSION['carrito'];

        // Save order
        $this->compra->id_user     = $user->id;
        $this->compra->costo_envio = $_SESSION['gastoEnvio'];
        $this->compra->subtotal    = $_SESSION['subtotal'];
        $this->compra->preciototal = $_SESSION['totalpagar'];
        $this->compra->status      = "Procesando";
        $this->compra->method      = "Conekta";
        $this->compra->id_datosenvio = $id_envio;
        $this->compra->save();

        $datos_envio = DatosEnvio::find($request->id_envio);

        // Set total in cents
        $total = (int) ($_SESSION['totalpagar'] * 100);

        // Create order array
        $charge = [
            'line_items' => [
                [
                    'name' => 'Pago de orden NO. ' . $this->compra->id,
                    'unit_price' => $total,
                    'quantity' => 1
                ]
            ],
            'currency' => 'MXN',
            'customer_info' => [],
            'charges' => [
                [
                    'payment_method' => [
                        'type' => 'default'
                    ]
                ]
            ],
            'shipping_lines' => [
                [
                    'amount' => 0,
                    'carrier' => 'Pendiente',
                    'method' => 'Pendiente',
                    'tracking_number' => 'ord_' . $this->compra->id,
                    'object' => 'shipping_line'
                ]
            ],
            'shipping_contact' => [
                'phone' => "55-5555-5555",
                'receiver' => $datos_envio->nombre . ' ' . $datos_envio->apellidos,
                'between_streets' => 'No indicado',
                'address' => [
                    'object' => 'shipping_address',
                    'street1' => $datos_envio->direccion1,
                    'city' => $datos_envio->localidad,
                    'state' => $datos_envio->region,
                    'country' => 'Mexico',
                    'postal_code' => '01010',
                    'residential' => true
                ],
                'object' => 'shipping_contact'
            ]
        ];

        // Execute charge
        try {
            $customer = \Conekta\Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'payment_sources' => [
                    [
                        'type' => 'card',
                        'token_id' => $token
                    ]
                ]
            ]);

            $charge['customer_info']['customer_id'] = $customer->id;

            // Create order
            $charge = \Conekta\Order::create($charge);

            if ($charge->payment_status == 'paid') {
                $this->compra->status = 'Pagado';
                $this->compra->chargeid = $charge->id;
                $this->compra->payment_error = '';
                $this->compra->save();

                /* Insertar Items */
                for ($i = 0; $i < sizeof($carrito); $i++) {

                    $producto = Productos::find($carrito[$i]['producto_id']);
                    $total = $producto->precio * $carrito[$i]['cantidad'];

                    // Quitar del Stock
                    $stock = (int) $producto->stock;
                    $dismiss_quantity = (int) $carrito[$i]['cantidad'];

                    $producto->stock = $stock - $dismiss_quantity;
                    $producto->save();

                    $compra_item = new CompraItem();
                    $compra_item->compra_id   = $this->compra->id;
                    $compra_item->id_producto = $carrito[$i]['producto_id'];
                    $compra_item->cantidad    = $carrito[$i]['cantidad'];
                    $compra_item->precio      = $producto->precio;
                    $compra_item->total       = $total;
                    $compra_item->save();
                }

                $this->sendOrderMail();

                unset($_SESSION['carrito']);
                unset($_SESSION['gastoEnvio']);
                unset($_SESSION['descuentoCupon']);
                unset($_SESSION['subtotal']);
                unset($_SESSION['totalpagar']);

                return response()->json(['ok' => true, 'message' => "success"]);
            } else {
                $this->compra->status = $charge->status;
                $this->compra->payment_error = $charge->failure_code . ': ' . $charge->failure_message;
                $this->compra->save();
                return response()->json(['ok' => false, 'message' => $charge->failure_code . ': ' . $charge->failure_message]);
            }
        } catch (\Conekta\ProcessingError $error) {
            $this->compra->payment_error = $error->getMessage();
        } catch (\Conekta\ParameterValidationError $error) {
            $this->compra->payment_error = $error->getMessage();
        } catch (\Conekta\Handler $error) {
            $this->compra->payment_error = $error->getMessage();
        }

        // Si atrapa un error
        $this->compra->status = 'Fallido';
        $this->compra->save();
        return response()->json(['ok' => false, 'message' => $this->compra->payment_error]);
    }

    public function payWithPaypal()
    {
        session_start();

        // Variables
        $carrito  = $_SESSION['carrito'];
        $data     = $_POST['data'];
        $id_envio = $_POST['id_envio'];

        $charge_id = $data['purchase_units'][0]['payments']['captures'][0]['id'];

        // Save order
        $this->compra->id_user     = Auth::user()->id;
        $this->compra->costo_envio = $_SESSION['gastoEnvio'];
        $this->compra->subtotal    = $_SESSION['subtotal'];
        $this->compra->preciototal = $_SESSION['totalpagar'];
        $this->compra->chargeid    = $charge_id;
        $this->compra->status      = 'Pagado';
        $this->compra->method      = 'PayPal';
        $this->compra->id_datosenvio = $id_envio;
        $this->compra->payment_error = '';
        $this->compra->save();

        /* Insertar Items */
        for ($i = 0; $i < sizeof($carrito); $i++) {

            $producto = Productos::find($carrito[$i]['producto_id']);
            $total = $producto->precio * $carrito[$i]['cantidad'];

            // Quitar del Stock
            $stock = (int) $producto->stock;
            $dismiss_quantity = (int) $carrito[$i]['cantidad'];

            $producto->stock = $stock - $dismiss_quantity;
            $producto->save();

            $compra_item = new CompraItem();
            $compra_item->compra_id   = $this->compra->id;
            $compra_item->id_producto = $carrito[$i]['producto_id'];
            $compra_item->cantidad    = $carrito[$i]['cantidad'];
            $compra_item->precio      = $producto->precio;
            $compra_item->total       = $total;
            $compra_item->save();
        }

        $this->sendOrderMail();

        unset($_SESSION['carrito']);
        unset($_SESSION['gastoEnvio']);
        unset($_SESSION['descuentoCupon']);
        unset($_SESSION['subtotal']);
        unset($_SESSION['totalpagar']);

        return response()->json(['ok' => true, 'message' => 'success']);
    }

    public function payWithOxxoPay(Request $request)
    {
        session_start();

        // Config conekta
        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setApiVersion('2.0.0');
        Conekta::setLocale('es');

        if (!Auth::check()) {
            return response()->json(['ok' => false, 'message' => 'No hay sessión iniciada']);
        }

        // User
        $user = Auth::user();

        // Varibles
        $id_envio = $request->id_envio;
        $carrito  = $_SESSION['carrito'];

        // Save order
        $this->compra->id_user     = $user->id;
        $this->compra->costo_envio = $_SESSION['gastoEnvio'];
        $this->compra->subtotal    = $_SESSION['subtotal'];
        $this->compra->preciototal = $_SESSION['totalpagar'];
        $this->compra->status      = "Procesando";
        $this->compra->method      = "OxxoPay";
        $this->compra->id_datosenvio = $id_envio;
        $this->compra->save();

        // Set total in cents
        $total = (int) ($_SESSION['totalpagar'] * 100);

        // Create order array
        $charge = [
            'line_items' => [
                [
                    'name' => 'Pago de orden NO. ' . $this->compra->id,
                    'unit_price' => $total,
                    'quantity' => 1
                ]
            ],
            'currency' => 'MXN',
            'customer_info' => [],
            "charges" => [
                [
                  "payment_method" => [
                    "type" => "oxxo_cash",
                  ]
                ]
            ],
        ];

        // Execute charge
        try {
            $customer = \Conekta\Customer::create([
                'name' => $user->name,
                'email' => $user->email,
            ]);

            $charge['customer_info']['customer_id'] = $customer->id;

            // Create order
            $order = \Conekta\Order::create($charge);

            if ($order->payment_status == 'pending_payment') {

                $reference = $order->charges[0]->payment_method->reference;
                $amount = $order->amount/100;

                $this->compra->status = 'Pendiente';
                $this->compra->chargeid = $order->id;
                $this->compra->save();

                /* Insertar Items */
                for ($i = 0; $i < sizeof($carrito); $i++) {

                    $producto = Productos::find($carrito[$i]['producto_id']);
                    $total = $producto->precio * $carrito[$i]['cantidad'];

                    // Quitar del Stock
                    $stock = (int) $producto->stock;
                    $dismiss_quantity = (int) $carrito[$i]['cantidad'];

                    $producto->stock = $stock - $dismiss_quantity;
                    $producto->save();

                    $compra_item = new CompraItem();
                    $compra_item->compra_id   = $this->compra->id;
                    $compra_item->id_producto = $carrito[$i]['producto_id'];
                    $compra_item->cantidad    = $carrito[$i]['cantidad'];
                    $compra_item->precio      = $producto->precio;
                    $compra_item->total       = $total;
                    $compra_item->save();
                }

                $this->sendOrderMail();
                $this->sendReferenceOxxoPay($reference, $amount);

                unset($_SESSION['carrito']);
                unset($_SESSION['gastoEnvio']);
                unset($_SESSION['descuentoCupon']);
                unset($_SESSION['subtotal']);
                unset($_SESSION['totalpagar']);

                return response()->json(['ok' => true, 'reference' => $reference, 'amount' => $amount]);
            } else {
                return response()->json(['ok' => false, 'message' => 'Hubo un problema al generar la referencia, intente nuevamente porfavor']);
            }
        } catch (\Conekta\ParameterValidationError $error) {
            $this->compra->payment_error = $error->getMessage();
        } catch (\Conekta\Handler $error) {
            $this->compra->payment_error = $error->getMessage();
        }

        // Si atrapa un error
        $this->compra->status = 'Fallido';
        $this->compra->save();
        return response()->json(['ok' => false, 'message' => $this->compra->payment_error]);
    }

    public function webhookOxxoPay(Request $request)
    {
        if($request->type == 'order.paid') {
            if ($request->data['object']['payment_status'] == 'paid' ) {
                $compra = Compra::where('chargeid', $request->data['object']['id'])->first();
                if ($compra) {
                    $user = User::find($compra->id_user);
                    $compra->status = 'Pagado';
                    $compra->save();
                    // Notifications mail
                    Mail::to($user->email)->send(new OrderPaidOxxoPay);
                }
            }
        }
    }

    public function sendReferenceOxxoPay($reference, $amount)
    {
        $user = Auth::user();

        $data = array(
            'reference'  => $reference,
            'total' => $amount,
        );

        Mail::to($user->email)->send(new ReferenceOxxoPay($data));
    }

    public function sendOrderMail()
    {
        $user = Auth::user();
        $datos_envio = DatosEnvio::find($this->compra->id_datosenvio);

        $nombre_envio = $datos_envio->nombre . ' ' . $datos_envio->apellidos;
        $email_envio  = $datos_envio->email;
        $direccion1   = $datos_envio->direccion1;
        $direccion2   = $datos_envio->direccion2;
        $cp           = $datos_envio->cp;
        $localidad    = $datos_envio->localidad;
        $region       = $datos_envio->region;
        $pais         = $datos_envio->pais;
        $telefono_envio = $datos_envio->telefono;
        $referencia   = $datos_envio->referencia;

        if (!empty($direccion2)) {
            $direccion_envio = $direccion1 . ', ' . $direccion2 . ', ' . $cp . ', ' . $localidad . ', ' . $region . ', ' . $pais;
        } else {
            $direccion_envio = $direccion1 . ', ' . $cp . ', ' . $localidad . ', ' . $region . ', ' . $pais;
        }

        $data_mail = array(
            'nombre'  => $user->name,
            'email'   => $user->email,
            'total'   => $_SESSION['totalpagar'],
            'method'  => $this->compra->method,
            'status'  => $this->compra->status,
            'nombre_envio'    => $nombre_envio,
            'direccion_envio' => $direccion_envio,
            'telefono_envio'  => $telefono_envio,
            'email_envio'     => $email_envio,
            'carrito'         => $_SESSION['carrito']
        );

        Mail::to($user->email)->cc('contacto@danatura.com.mx')->send(new CompraExitosa($data_mail));
    }

    public function applyCoupon(Request $request)
    {
        session_start();

        $codigo = $request->codigo;
        $coupon = Coupon::where('codigo', $codigo)->where('status', 'Activo')->first();

        if ($coupon) {
            $totalpagar = $_SESSION['totalpagar'];
            $tipo = $coupon->tipo;
            $cantidad = $coupon->cantidad;

            if ($tipo == 'Porcentaje') {
                // Descuento por porcentaje
                $descuento = $totalpagar * $cantidad;
                $descuento = $descuento / 100;
                $_SESSION['descuentoCupon'] = $descuento;
                $_SESSION['totalpagar'] = $_SESSION['totalpagar'] - $_SESSION['descuentoCupon'];
            } else {
                // Descuento por cantidad
                $_SESSION['descuentoCupon'] = $cantidad;
                $_SESSION['totalpagar'] = $_SESSION['totalpagar'] - $cantidad;
            }
            return back()->with('success_cupon', 'El descuento del cupón se ha aplicado con éxito');
        } else {
            return back()->with('error_cupon', 'El cupón ingresado no existe o está inactivo');
        }
    }
}
