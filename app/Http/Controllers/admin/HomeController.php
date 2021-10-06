<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Productos;
use App\Models\VentaProductos;
use App\Models\User;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productos=Productos::all();
        $pedidos=VentaProductos::all();
        $usuarios=User::all();
        $subscriptores=DB::table('newsletter')->get();
       
        return view('admin.home',['productos'=> $productos,'pedidos'=> $pedidos,'usuarios'=> $usuarios,'subscriptores'=> $subscriptores]);
    }
}
