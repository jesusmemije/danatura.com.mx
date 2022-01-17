<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\DatosEnvio;
use App\Models\Productos;
use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VentasProductosController extends Controller
{
    public function index()
    {
        $datosdirection = DB::table('datos_envios')
                ->select('datos_envios.*')
                ->get();
            
        $compra = DB::table('compra')
                ->join('users','compra.id_user','=','users.id')
                ->join('tiposuario','users.tipo','=','tiposuario.id')
                ->select('compra.*','users.name','tiposuario.tipo','compra.id as idventa')

                ->distinct('compra.id')
                ->get();

        $compra_item = DB::table('compra_item')
                ->join('compra','compra_item.compra_id','=','compra.id')
                ->join('productos','compra_item.id_producto','=','productos.id')
                ->select('compra_item.*','productos.*')
                ->distinct('compra_item.id')
                ->get();

        return view('admin.ventas.index',compact(['compra', $compra, 'compra_item', $compra_item, 'datosdirection', $datosdirection]));
    }

    public function getDireccionCustomer( Request $request )
    {
        $datos_envio = DatosEnvio::where('id_user', '=', $request->idcustomer)->latest('created_at')->first();
        return response()->json([
            'datos_envio' => $datos_envio
        ]);
    }

    public function saveOrderManually( Request $request )
    {
        session_start();

        if ( !isset($_SESSION['carrito']) || empty($_SESSION['carrito']) ) {
            return response()->json(['ok' => false, 'message' => 'El carrito esta vacío']);
        }

        // Variables
        $carrito  = $_SESSION['carrito'];
        $id_user  = $request->id_user;
        $id_envio = $request->id_envio;

        // Save order
        $compra = new Compra();
        $compra->id_user     = $id_user;
        $compra->costo_envio = $_SESSION['gastoEnvio'];
        $compra->subtotal    = $_SESSION['subtotal'];
        $compra->preciototal = $_SESSION['totalpagar'];
        $compra->status      = 'Pagado';
        $compra->method      = 'Manualmente';
        $compra->id_datosenvio = $id_envio;
        $compra->save();

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
            $compra_item->compra_id   = $compra->id;
            $compra_item->id_producto = $carrito[$i]['producto_id'];
            $compra_item->cantidad    = $carrito[$i]['cantidad'];
            $compra_item->precio      = $producto->precio;
            $compra_item->total       = $total;
            $compra_item->save();
        }

        // sendOrderMail();

        unset($_SESSION['carrito']);
        unset($_SESSION['totalpagar']);

        return response()->json(['ok' => true, 'message' => 'success']);
    }

    public function saveUserManually( Request $request )
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'ok' => false, 
                'message' => 'Ya existe un usuario registrado con este E-mail de nombre: ' . $user->name
            ]);
        }

        $user = new User();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->tipo  = $request->tipo;
        $user->password = Hash::make('12345678');
        $user->save();

        return response()->json([
            'ok' => true,
            'user_id' => $user->id,
            'name' => $user->name
        ]);
    }

    public function create()
    {
        $users = User::select('id', 'name', 'email')->get();
        $products = Productos::select('id', 'nombre', 'gramos', 'precio', 'fotografia')->get();
        $tipos = TipoUsuario::get();
        return view('admin.ventas.create', compact('users', 'products', 'tipos'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }


    public function cambiarEstadoEntrega(Request $request)
    {
        $cambio_venta=DB::table('compra')
        ->where('id','=',$request->id_venta)
        ->update([
            'estado_entrega'=>$request->estado_entrega,
        ]);

        if( $cambio_venta ){
            return redirect('admin/pedidos/')->with('status', 'El estado de entrega del pedido se ha actualizado');
        } else {
            return redirect('admin/pedidos/')->with('wrong', 'El estado de entrega no se pudo actualizar');
        }

    }
}
