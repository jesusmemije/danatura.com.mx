<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;

class VentasProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ventas=Compra::leftJoin('datos_envios','compra.id_datosenvio','=','datos_envios.id')
        ->leftJoin('compra_item','compra.id','=','compra_item.compra_id')
        ->get(['datos_envios.*', 'compra.*', 'compra_item.*','compra.id as idventa']);


        return view('admin.ventas.index',['ventas'=> $ventas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function cambiarEstadoEntrega(Request $request){


        $cambio_venta=DB::table('compra')
        ->where('id','=',$request->id_venta)
        ->update([

            'estado_entrega'=>$request->estado_entrega,
        ]);

        if($cambio_venta){
            return redirect('admin/pedidos/')->with('status', 'El estado de entrega del pedido se ha actualizado');
        }else{
            return redirect('admin/pedidos/')->with('wrong', 'El estado de entrega no se pudo actualizar');
        }

    }
}
