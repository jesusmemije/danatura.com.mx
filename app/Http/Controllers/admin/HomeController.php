<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Productos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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

     * @return Renderable
     */
    public function index()
    {

        $productos = Productos::all();

        $pedidos = Compra::all();

        $usuarios = User::all();

        $subscriptores = DB::table('newsletter')->get();

        return view('admin.home', ['productos' => $productos, 'pedidos' => $pedidos, 'usuarios' => $usuarios, 'subscriptores' => $subscriptores]);

    }

    public function venta_zonas()
    {

        $zonas = DB::table('venta_zonas')->get();

        return view('admin.venta_zona.index_venta', ['zonas' => $zonas]);

    }

    public function create_zona()
    {

        return view('admin.venta_zona.create_zona');

    }

    public function store_zona(Request $request)
    {

        $hecho = DB::table('venta_zonas')->insert([

            'nombre_zona' => $request->nombre_zona,
            'descripcion_zona' => $request->descripcion_zona,

        ]);

        if ($hecho) {

            return redirect()->back()->with('success', 'Zona registrada con éxito.');

        } else {

            return redirect()->back()->with('success', 'Zona no se pudo registrar, intentelo de nuevo.');

        }
    }

    public function edit_zona($id)
    {

        $zonas = DB::table('venta_zonas')
            ->where('id', '=', $id)
            ->get();

        return view('admin.venta_zona.edit_venta', ['zonas' => $zonas]);
    }

    public function update_zona(Request $request)
    {

        $actualizado = DB::table('venta_zonas')
            ->where('id', '=', $request->id)
            ->update([

                'nombre_zona' => $request->nombre_zona,
                'descripcion_zona' => $request->descripcion_zona,

            ]);
        if ($actualizado) {

            return redirect()->back()->with('success', 'Datos de zona actualizada con éxito.');

        } else {

            return redirect()->back()->with('success', 'Datos de Zona no se pudo actualizar, intentelo de nuevo.');

        }

    }

    public function zona_destroy($id)
    {

        DB::table('venta_zonas')->where('id', '=', $id)->delete();

        return redirect()->back()->with('success', 'Zona eliminada');
    }

    public function usuarios_zona($id_zona)
    {

        $usuarios_no_agregdos = DB::table('users')
            ->whereNotExists(function ($query) use ($id_zona) {
                $query->select(DB::raw(1))
                    ->from('zona_usuario')
                    ->whereColumn('zona_usuario.id_usuario', 'users.id')
                    ->where('zona_usuario.id_zona_venta', '=', $id_zona);
            })
            ->orderBy('name', 'asc')
            ->get();

        $zona = DB::table('venta_zonas')
            ->where('id', '=', $id_zona)
            ->get();

        $zonas_usuarios = DB::table('venta_zonas')
            ->join('zona_usuario', 'venta_zonas.id', 'zona_usuario.id_zona_venta')
            ->join('users', 'zona_usuario.id_usuario', 'users.id')
            ->select('users.name', 'venta_zonas.nombre_zona', 'venta_zonas.id', 'zona_usuario.id as id_zona_usuario')
            ->where('venta_zonas.id', '=', $id_zona)
            ->get();
        // dd($zonas_usuarios);

        if (count($zona) == 0) {
            $nombre_zona = '';

        } else {
            $nombre_zona = $zona[0]->nombre_zona;
        }

        return view('admin.venta_zona.lista_usuarios', ['zonas_usuarios' => $zonas_usuarios, 'usuarios' => $usuarios_no_agregdos, 'nombre_zona' => $nombre_zona, 'id_zona' => $id_zona]);
    }

    public function usuarios_zona_store(Request $request)
    {

        $hecho = DB::table('zona_usuario')->insert([

            'id_zona_venta' => $request->id_zona_venta,
            'id_usuario' => $request->id_usuario,

        ]);

        return response()->json(['ok' => true]);

    }

    public function usuarios_zona_destroy($id)
    {

        DB::table('zona_usuario')->where('id', '=', $id)->delete();

        return redirect()->back()->with('success', 'Usuario eliminado de la zona');

    }

    public function productos_zona($id_zona)
    {

        $productos_no_agregdos = DB::table('productos')
            ->whereNotExists(function ($query) use ($id_zona) {
                $query->select(DB::raw(1))
                    ->from('zona_producto')
                    ->whereColumn('zona_producto.id_producto', 'productos.id')
                    ->where('zona_producto.id_zona_venta', '=', $id_zona);
            })
            ->orderBy('nombre', 'asc')
            ->get();

        $zona = DB::table('venta_zonas')
            ->where('id', '=', $id_zona)
            ->get();

        $zonas_productos = DB::table('venta_zonas')
            ->join('zona_producto', 'venta_zonas.id', 'zona_producto.id_zona_venta')
            ->join('productos', 'zona_producto.id_producto', 'productos.id')
            ->select('productos.nombre as nombre_producto', 'productos.descripcion', 'productos.precio', 'venta_zonas.nombre_zona', 'venta_zonas.id', 'zona_producto.id as id_zona_producto')
            ->where('venta_zonas.id', '=', $id_zona)
            ->get();
        // dd($zonas_usuarios);

        if (count($zona) == 0) {
            $nombre_zona = '';

        } else {
            $nombre_zona = $zona[0]->nombre_zona;
        }

        // dd($id_zona,$productos_no_agregdos,$zona,$zonas_productos,$nombre_zona);

        return view('admin.venta_zona.lista_productos', ['zonas_productos' => $zonas_productos, 'productos' => $productos_no_agregdos, 'nombre_zona' => $nombre_zona, 'id_zona' => $id_zona]);
    }

    public function productos_zona_store(Request $request)
    {

        $hecho = DB::table('zona_producto')->insert([

            'id_zona_venta' => $request->id_zona_venta,
            'id_producto' => $request->id_producto,

        ]);

        return response()->json(['ok' => true]);

    }

    public function productos_zona_destroy($id)
    {

        DB::table('zona_producto')->where('id', '=', $id)->delete();

        return redirect()->back()->with('success', 'Producto eliminado de la zona');

    }

    public function numeros_whatsapp()
    {
        $numeros_atencion = DB::table('numeros_whatsapp')
            ->get();

        return view('admin.whatsapp.index_whatsapp', ['numeros_atencion' => $numeros_atencion]);
    }

    public function agregar_numeros_whatsapp(Request $request)
    {

        $hecho = DB::table('numeros_whatsapp')->insert([

            'area_whatsapp' => $request->area_whatsapp,
            'descripcion_whatsapp' => $request->descripcion_whatsapp,
            'link_whatsapp' => $request->link_whatsapp,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        if ($hecho) {

            return redirect()->back()->with('success', 'Número de whatsapp registrada con éxito.');

        } else {

            return redirect()->back()->with('success', 'Número de whatsapp no se pudo registrar, intentelo de nuevo.');

        }
    }

    public function update_numeros_whatsapp(Request $request)
    {

        $actualizado = DB::table('numeros_whatsapp')
            ->where('id', '=', $request->id)
            ->update([

                'area_whatsapp' => $request->area_whatsapp,
                'descripcion_whatsapp' => $request->descripcion_whatsapp,
                'link_whatsapp' => $request->link_whatsapp,
                'updated_at' => Carbon::now(),

            ]);
        if ($actualizado) {

            return redirect()->back()->with('success', 'Número de whatsapp actualizada con éxito.');

        } else {

            return redirect()->back()->with('success', 'Número de whatsapp no se pudo actualizar, intentelo de nuevo.');

        }

    }

    public function destroy_numeros_whatsapp($id)
    {

        $eliminado = DB::table('numeros_whatsapp')->where('id', '=', $id)->delete();

        if ($eliminado) {

            return redirect()->back()->with('success', 'Número de whatsapp eliminado con éxito.');

        } else {

            return redirect()->back()->with('error', 'Número de whatsapp no se pudo eliminar, intentelo de nuevo.');

        }

    }
}
