<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\CompraExitosa;
use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\DatosEnvio;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Conekta\Conekta;
use Conekta\Order;
use Illuminate\Support\Facades\Http;
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
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('front/checkout');
    }

    public function pay(Request $request)
    {
        $payment_id = $request->get('payment_id');

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=" . config('services.mercadopago.token'));
        $response = json_decode($response);

        if ($response->status == "approved") {
            # code...
        }
    }

    public function payWithMercadoPago(Request $request)
    {
        $payment_id = $request->get('payment_id');

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=" . config('services.mercadopago.token'));
        $response = json_decode($response);

        if ($response->status == "approved") {
            # code...
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
            return response()->json(['ok' => 'false', 'message' => 'No hay sessión iniciada']);
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

        /* Insertar Items */
        for ($i = 0; $i < sizeof($carrito); $i++) {

            $producto = Productos::find($carrito[$i]['producto_id']);
            $total = $producto->precio * $carrito[$i]['cantidad'];

            $compra_item = new CompraItem();
            $compra_item->compra_id   = $this->compra->id;
            $compra_item->id_producto = $carrito[$i]['producto_id'];
            $compra_item->cantidad    = $carrito[$i]['cantidad'];
            $compra_item->precio      = $producto->precio;
            $compra_item->total       = $total;
            $compra_item->save();
        }

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
                $this->sendOrderMail();

                unset($_SESSION['carrito']);
                unset($_SESSION['totalpagar']);

                return response()->json(['ok' => 'true', 'message' => "success"]);
            } else {
                $this->compra->status = $charge->status;
                $this->compra->payment_error = $charge->failure_code . ': ' . $charge->failure_message;
                $this->compra->save();
                return response()->json(['ok' => 'false', 'message' => $charge->failure_code . ': ' . $charge->failure_message]);
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
        return response()->json(['ok' => 'false', 'message' => $this->compra->payment_error]);
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
        unset($_SESSION['totalpagar']);

        return response()->json(['ok' => 'true', 'message' => 'success']);
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
            'status'  => 'Pagado',
            'nombre_envio'    => $nombre_envio,
            'direccion_envio' => $direccion_envio,
            'telefono_envio'  => $telefono_envio,
            'email_envio'     => $email_envio,
            'carrito'         => $_SESSION['carrito']
        );

        Mail::to($user->email)->cc('contacto@danatura.com.mx')->send(new CompraExitosa($data_mail));
    }
}
