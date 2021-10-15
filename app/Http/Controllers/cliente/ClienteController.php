<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DatosEnvio;

class ClienteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            $datosdirection = DB::table('datos_envios')
                ->join('users','datos_envios.id_user','=','users.id')
                ->select('datos_envios.*')
                ->where('datos_envios.id_user','=',auth()->user()->id)
                ->distinct('datos_envios.direccion1')
                ->get();
            
            // Historial de compras
            
            $historialPedido = DB::table('venta_productos')
                ->join('users','venta_productos.id_user','=','users.id')
                ->join('productos','venta_productos.id_producto','=','productos.id')
                ->join('datos_envios','venta_productos.id_datosenvio','=','datos_envios.id')
                ->select('venta_productos.*','users.name', 'productos.nombre AS Producto', 'datos_envios.direccion1')
                ->where('venta_productos.id_user','=',auth()->user()->id)
                ->get();

        return view('cliente.historial_pedidos',compact(['historialPedido',$historialPedido,'datosdirection',$datosdirection]));
    }

    public function store(Request $request)
    {
        $validacion = $this->validate($request, [
            'nombre'    => 'required|string',
            'apellidos' => 'required|string',
            'empresa'   => 'string',
            'pais'      => 'required|string',
            'direccion1'=> 'required',
            'direccion2'=> 'string',
            'localidad' => 'required|string',
            'region'    => 'required|string',
            'cp'        => 'required',
            'telefono'  => 'required|numeric',
            'email'     => 'required|email',
            'rfc'       => 'string',
            'referencia'=> 'string',
        ]);

        $newDirection = new DatosEnvio();
        $newDirection->nombre = $request->input('nombre');
        $newDirection->apellidos = $request->input('apellidos');
        $newDirection->empresa = $request->input('empresa');
        $newDirection->pais = $request->input('pais');
        $newDirection->direccion1 = $request->input('direccion1');
        $newDirection->direccion2 = $request->input('direccion2');
        $newDirection->localidad = $request->input('localidad');
        $newDirection->region = $request->input('region');
        $newDirection->cp = $request->input('cp');
        $newDirection->telefono = $request->input('telefono');
        $newDirection->email = $request->input('email');
        $newDirection->rfc = $request->input('rfc');
        $newDirection->referencia = $request->input('referencia');
        $newDirection->save();

        return redirect()->route('historial_pedidos.index')->with('mensaje', 'Dirección registrada con exito.');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'edit_nombre' => 'required|string',
            'edit_apellidos' => 'required|string',
            'edit_empresa' => 'string',
            'edit_pais' => 'required|string',
            'edit_direccion1' => 'required',
            'edit_direccion2' => 'string',
            'edit_localidad' => 'required|string',
            'edit_region' => 'required|string',
            'edit_cp' => 'required',
            'edit_telefono' => 'required|numeric|min:11',
            'edit_email' => 'required|email',
            'edit_rfc' => 'required|string',
            'edit_referencia' => 'required|string',
        ]);

        $id = $request->edit_id;
        $updateDirection = request()->except(['_token','_method']);
        $updateDirection = DatosEnvio::find($id);

        $updateDirection->nombre     = $request->input('edit_nombre');
        $updateDirection->apellidos  = $request->input('edit_apellidos');
        $updateDirection->empresa    = $request->input('edit_empresa');
        $updateDirection->pais       = $request->input('edit_pais');
        $updateDirection->direccion1 = $request->input('edit_direccion1');
        $updateDirection->direccion2 = $request->input('edit_direccion2');
        $updateDirection->localidad  = $request->input('edit_localidad');
        $updateDirection->region     = $request->input('edit_region');
        $updateDirection->cp         = $request->input('edit_cp');
        $updateDirection->telefono   = $request->input('edit_telefono');
        $updateDirection->email      = $request->input('edit_email');
        $updateDirection->rfc        = $request->input('edit_rfc');
        $updateDirection->referencia = $request->input('edit_referencia');

        $updateDirection->save();

        return redirect()->route('historial_pedidos.index')->with('mensaje', 'Dirección Actualizada con Exito.');
    }

    public function destroy($id)
    {
        $direccion=DatosEnvio::find($id);
        $direccion->delete();
        return redirect()->route('historial_pedidos.index')->with('mensaje','Dirección Eliminada con Exito.');
    }
}
