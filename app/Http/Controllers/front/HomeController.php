<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DatosEnvio;
use App\Models\Productos;
use App\Models\Compra;
use App\Models\User;
use App\Models\Contacto;

// Send mail
use App\Mail\CompraExitosa;
use App\Mail\MensajeContacto;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    function index()
    {
        $masvendidos =
            DB::table('compra_item')
            ->join('productos', 'compra_item.id_producto', '=', 'productos.id')

            ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,fotografia,galeria')
            ->orderByRaw('sum(cantidad) desc ')
            ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'fotografia', "galeria")
            ->limit(6)
            ->get();

        $productos = Productos::all();

        return view('front/home', ['masvendidos' => $masvendidos, 'productos' => $productos]);
    }

    function registrar_contacto(Request $request)
    {
        $contacto = new Contacto();
        $contacto->nombre  = $request->nombre;
        $contacto->email   = $request->email;
        $contacto->asunto  = $request->asunto;
        $contacto->mensaje = $request->mensaje;

        Mail::to('contacto@danatura.com.mx')->send(new MensajeContacto($contacto));

        if ($contacto->save()) {
            return redirect()->back()->with('mensaje', 'Su información se ha enviado a nuestro equipo de trabajo.');
        } else {
            return redirect()->back()->with('error', 'Su información no ha podido ser enviada, intentelo de nuevo.');
        }
    }

    function productos()
    {
        session_start();
        $user = Auth::user();
        $total_productos = Productos::all()->count();

        $_SESSION['thetotal'] = 0;

        $categorias = DB::table('categorias')->get();

        $productos = Productos::paginate(9);
        //$productos= Productos::all();
        return view('front/productos', ["productos" => $productos, 'user' => $user, 'categorias' => $categorias]);
    }

    function detalle_producto(Request $request)
    {
        $masvendidos =
            DB::table('compra_item')
            ->join('productos', 'compra_item.id_producto', '=', 'productos.id')

            ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,fotografia,galeria')
            ->orderByRaw('sum(cantidad) desc ')
            ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'fotografia', "galeria")
            ->limit(6)
            ->get();

        $producto = Productos::where('nombre', $request->producto)->first();

        return view('front/detalle-producto', ["producto" => $producto, "masvendidos" => $masvendidos]);
    }

    public function puntos_venta(Request $request)
    {
        $productos = Productos::all();

        $estado = $request->estado;
        $ciudad = $request->ciudad;
        $busqueda = $request->busqueda;

        if ($estado != '' || $ciudad != '' || $busqueda != '') {

            $puntos = DB::table('puntos_ventas')
                ->where('estado', 'like', '%' . $estado . '%')
                ->where('ciudad', 'like', '%' . $ciudad . '%')

                ->get();
        } else {
            $puntos = DB::table('puntos_ventas')->get();
        }

        if ($busqueda != '') {
            $puntos = DB::table('puntos_ventas')
                ->orWhere('estado', 'like', '%' . $busqueda . '%')
                ->orWhere('ciudad', 'like', '%' . $busqueda . '%')
                ->orWhere('nombre_comercial', 'like', '%' . $busqueda . '%')
                ->orWhere('direccion', 'like', '%' . $busqueda . '%')
                ->get();
        }

        return view('front/puntos-venta', ["puntos" => $puntos, 'productos' => $productos]);
    }

    public function registro_normal(Request $request)
    {
        $usuario = User::create([
            'name'        => strtoupper($request->name),
            'email'      => $request->email,
            'tipo'      => 2,
            'password' => Hash::make($request['password'])
        ])->save();

        return redirect()->route('home');
    }

    public function filtrar_puntos(Request $request)
    {
        $estado = $request->estado;
        $ciudad = $request->ciudad;
        $buscador = $request->buscador;

        $puntos = DB::table('puntos_ventas')
            ->where('estado', 'like', '%' . $estado . '%')
            ->where('ciudad', 'like', '%' . $ciudad . '%')

            ->get();

        return view('front/puntos-venta', ["puntos" => $puntos]);
    }

    public function get_ciudades()
    {
        $nombre = $_POST['ciudad'];

        $ciudades = DB::table('puntos_ventas')
            ->select(DB::raw('distinct ciudad'))
            ->where('estado', '=', $nombre)
            ->whereNotNull('ciudad')
            ->get();
        echo json_encode($ciudades);
    }

    public function newsletter(Request $request)
    {
        $correo = $_POST['correo'];

        $validado = $request->validate([
            'correo' => 'email',

        ]);

        $existe = DB::table('newsletter_subs')
            ->where('correo', '=', $request->correo)
            ->first();

        if (!empty($existe)) {
            $response = ['mensaje' => "ya existe"];
            echo json_encode($response);
            die();
        }

        $hecho = DB::table('newsletter_subs')->insert([
            'correo' => $request->correo,
        ]);

        if ($hecho) {
            $response = ['mensaje' => "bien"];
            echo json_encode($response);
        }
    }

    public function dudas(Request $request)
    {
        if ($request->duda == "" || empty($request->duda)) {
            return redirect()->back()->with('error', 'mal');
            die();
        }

        $hecho = DB::table('dudas_comentarios')->insert([
            'duda_comentario' => $request->duda,
        ]);

        if ($hecho) {
            $response = ['mensaje' => "bien"];
            return redirect()->back()->with('mensaje', 'bien');
        } else {
            $response = ['mensaje' => "bien"];
            return redirect()->back()->with('error', 'mal');
        }
    }

    function filtrar_productos(Request $request)
    {
        if ($request->ajax()) {

            $tipo_precio = 'normal';
            $precio_normal = '';

            if (auth()->user() != null) {

                $tipo = auth()->user()->tipo;

                $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

                $thetipo = $tipos->tipo;

                if ($thetipo == "Mayorista") {

                    $tipo_precio = 'mayorista';
                }
                if ($thetipo == "Nutriologo") {

                    $tipo_precio = 'nutriologo';
                }
            }

            $data = DB::table('productos')
                ->join('categoriasproductos as cp', 'productos.id', '=', 'cp.id_producto')
                ->where('cp.id_categoria', '=', $request->id)
                ->get();

            $thespan = "";
            $output = '';
            $hayono = '';

            if (!$data->isEmpty()) {
                foreach ($data as $row) {

                    $nombre = $row->nombre;

                    $fotografia = $row->fotografia;
                    $source = $fotografia;
                    if ($fotografia == "") {
                        $source = asset("assets/productos/goldenmilk.png");
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset("assets/productos") . "/" . $fotografia;
                    }

                    if (strpos($row->precio, '.') !== false) {

                        $precio = $row->precio;
                    } else {
                        $precio = $row->precio . ".00";
                    }

                    //Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio . ".00";
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$' . $precio_normal . ' MXN</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista . ".00";
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$' . $precio_normal . ' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$' . $precio . ' MXN</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo . ".00";
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$' . $precio_normal . ' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$' . $precio . ' MXN</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="detalle-producto?producto=' . $nombre . '">COMPRAR</a>
                    </div>';


                    $output .= '
                    <div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            <span class="nuevo-circle">Nuevo</span>
                            <i id="fav' . $row->id . '"  onclick="fav(this,' . $row->id . ')" class="fas fa-heart corazon"></i>
                            <a  href="detalle-producto?producto=' . $nombre . '">
                            <img class="img-thumbnail" src="' . $foto_principal . '" alt="">
                            </a>
                            <br>
                            <div style="padding:4%;">
                            <a  href="detalle-producto?producto=' . $nombre . '">
                                <span style="color:#73472b; font-family:AmasisMTStd-Bold;">' . $row->nombre . '</span><br> 
                                </a>
                                <span style="color:#73472b; class="cls2" >' . $row->sabor . '</span><br> 
                                ' . $thespan . '
                                <br>
                                ' . $hayono . '
                            </div> 
                            </div>
                        </li>
                    </div>';
                }
                echo $output;
            }
        }
    }

    function load_more(Request $request)
    {
        session_start();

        $aux_seg = 0;

        $count = Productos::all()->count();

        $tipo_precio = 'normal';
        $precio_normal = '';

        if (auth()->user() != null) {

            $tipo = auth()->user()->tipo;
            $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

            $thetipo = $tipos->tipo;

            if ($thetipo == "Mayorista") {
                $tipo_precio = 'mayorista';
            }
            if ($thetipo == "Nutriologo") {
                $tipo_precio = 'nutriologo';
            }
        }

        if ($request->ajax()) {
            if ($request->id > 0) {
                $data = DB::table('productos')
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(9)
                    ->get();
            } else {
                $data = DB::table('productos')
                    ->orderBy('id', 'DESC')
                    ->limit(9)
                    ->get();
            }

            $thespan = "";
            $output = '';
            $hayono = '';
            $last_id = '';

            if (!$data->isEmpty()) {

                if (isset($_SESSION['thetotal'])) {

                    if ($aux_seg < $count) {
                        $aux_seg = $_SESSION['thetotal'] + 9;
                        $_SESSION['thetotal'] = $aux_seg;

                        if ($aux_seg >= $count) {
                            $aux_seg = $count;
                        }
                    } else {
                        $aux_seg = $count;
                    }
                } else {
                    $_SESSION['thetotal'] = 0;
                }

                foreach ($data as $row) {

                    $nombre = $row->nombre;
                    $fotografia = $row->fotografia;
                    $source = $fotografia;
                    if ($fotografia == "") {
                        $source = asset("assets/productos/goldenmilk.png");
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset("assets/productos") . "/" . $fotografia;
                    }

                    //Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio . ".00";
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$' . $precio_normal . ' MXN</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista . ".00";
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$' . $precio_normal . ' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$' . $precio . ' MXN</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo . ".00";
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$' . $precio_normal . ' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$' . $precio . ' MXN</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="detalle-producto?producto=' . $nombre . '">COMPRAR</a>
                    </div>';

                    $output .= '<div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            <span class="nuevo-circle">Nuevo</span>
                            <i id="fav' . $row->id . '"  onclick="fav(this,' . $row->id . ')" class="fas fa-heart corazon"></i>
                            <a  href="detalle-producto?producto=' . $nombre . '">
                            <img class="img-thumbnail" src="' . $foto_principal . '" alt=""> </a>
                            <br>
                            <div style="padding:4%;">
                                <a  href="detalle-producto?producto=' . $nombre . '">
                                    <span style="color:#73472b; font-family:AmasisMTStd-Bold;">' . $row->nombre . '</span><br> </a>
                                    <span style="color:#73472b; class="cls2" >' . $row->sabor . '</span><br> 
                                    ' . $thespan . '
                                    <br>

                                    ' . $hayono . '
                                    
                                </div> 
                            </div>
                        </li>
                    </div>';

                    $last_id = $row->id;
                }

                $output .=
                    '<div id="showpp" class="col-md-12 d-flex justify-content-center" style="color:#73472b; font-weight:520;">
                    <span>MOSTRANDO ' . $aux_seg . ' de ' . $count . ' productos</span>
                </div>';

                if ($aux_seg == 9) {
                    $progress_with = 'width: 16.5%;';
                } elseif ($aux_seg == 18) {
                    $progress_with = 'width: 33%;';
                } elseif ($aux_seg == 27) {
                    $progress_with = 'width: 49.5%;';
                } elseif ($aux_seg == 36) {
                    $progress_with = 'width: 66%;';
                } elseif ($aux_seg == 45) {
                    $progress_with = 'width: 82.5%;';
                } else {
                    $progress_with = 'width: 100%;';
                }

                $output .=
                    '<div id="showpro" class="col-md-3 divbar" style="margin-left: 38%;">
                    <div id="progressbar">
                        <div style="' . $progress_with . '"></div>
                    </div>
                </div>';

                $output .=
                    '<div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar" data-id="' . $last_id . '" id="load_more_button" >CARGAR MÁS PRODUCTOS</a>
                </div>';
            } else {

                $output .= '
                <div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar">No hay más productos</a>
                </div>';
            }

            echo $output;
        }
    }

    public function misfavoritos()
    {
        if (isset($_COOKIE['thecookie']) && $_COOKIE['thecookie'] != "") {

            $cke = explode(',', $_COOKIE['thecookie']);

            $misfavoritos = Productos::whereIn('id', $cke)->get();

            return view('front/mis-favoritos', ["favoritos" => $misfavoritos]);
        } else {

            $masvendidos =
                DB::table('compra_item')
                ->join('productos', 'compra_item.id_producto', '=', 'productos.id')

                ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,fotografia,galeria')
                ->orderByRaw('sum(cantidad) desc ')
                ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'fotografia', "galeria")
                ->limit(6)
                ->get();

            return redirect()->route('home', ['masvendidos' => $masvendidos]);
        }
    }

    public function carrito()
    {
        return view('front/carrito');
    }

    public function procesa()
    {
        session_start();

        if (isset($_POST['cantidad'])) {
            if ($_POST['cantidad'] <= 0) {
                $respuesta = ['operacion' => "zero"];
                echo json_encode($respuesta);
                die();
            }
        }

        if (isset($_POST['id'])) {

            $producto = Productos::find($_POST['id']);

            if ($producto->stock < $_POST["cantidad"]) {
                $respuesta = ['operacion' => "excede", "cantidad" => $producto->stock];
                echo json_encode($respuesta);
                die();
            }

            $producto_id = $_POST['id'];
            $cantidad = $_POST['cantidad'];
            $nombre = $producto->nombre;
            $precio = $producto->precio;

            //Para verificar si ya existe un ID de producto dentro del carrito.
            if (isset($_SESSION['carrito'])) {

                //Cuando ya existe el carrito,  y quiere agregar más productos que se en total supere el stock.
                $aux_cantidad_total = 0;
                $auxCarrito = [];
                $auxCarrito = $_SESSION['carrito'];

                $existe = false;
                foreach ($auxCarrito as $key => $value) {
                    $aux_cantidad_total = $aux_cantidad_total + $value['cantidad'];

                    if ($producto_id == $key) {
                        $existe = true;
                    }
                }

                $aux_cantidad_total = $aux_cantidad_total + $_POST["cantidad"];

                if ($aux_cantidad_total > $producto->stock) {

                    $respuesta = ['operacion' => "excede", "cantidad" => $producto->stock - $aux_cantidad_total];
                    echo json_encode($respuesta);
                    die();
                }

                if (!$existe) {
                    array_push($auxCarrito, ['producto_id' => $producto_id, 'nombre' => $nombre, 'precio_unit' => $precio, 'cantidad' => $cantidad]);

                    $respuesta = ['operacion' => "bien"];
                    echo json_encode($respuesta);
                } else {
                    $respuesta = ['operacion' => "doble"];
                    echo json_encode($respuesta);
                }

                $_SESSION['carrito'] = $auxCarrito;
            } else {
                //Cuando no hay registros previos de ese producto.
                $carrito = [];
                array_push($carrito, ['producto_id' => $producto_id, 'nombre' => $nombre, 'precio_unit' => $precio, 'cantidad' => $cantidad]);

                $_SESSION['carrito'] = $carrito;
                //echo sizeof($carrito);
                $respuesta = ['operacion' => "bien"];
                echo json_encode($respuesta);
            }
        }

        if (isset($_POST['remove'])) {
            $producto_id = $_POST['remove'];

            if (isset($_SESSION['carrito'])) {

                $auxCarrito = $_SESSION['carrito'];

                for ($i = 0; $i < sizeof($auxCarrito); $i++) {
                    if ($producto_id == $auxCarrito[$i]['producto_id']) {
                        array_splice($auxCarrito, $i, 1);
                    }
                }
                $_SESSION['carrito'] = $auxCarrito;
            }
        }
    }

    public function datos_envio(Request $request)
    {
        //Para verificar que el usuario solamente está cambiando su dirección de envio y "proteger" los otros datos.
        if (!empty($request->dato_id)) {
            $msj = 'Los datos se actualizaron correctamente';
            $datosenvio = DatosEnvio::find($request->dato_id);
        } else {
            $msj = 'Los datos se guardaron correctamente';
            $datosenvio = new DatosEnvio();
        }

        $datosenvio->id_user = Auth::user()->id;
        $datosenvio->nombre = $request->nombre;
        $datosenvio->apellidos = $request->apellidos;
        $datosenvio->empresa = $request->empresa;
        $datosenvio->pais = $request->pais;
        $datosenvio->direccion1 = $request->direccion1;
        $datosenvio->direccion2 = $request->direccion2;
        $datosenvio->localidad = $request->localidad;
        $datosenvio->region = $request->region;
        $datosenvio->cp = $request->cp;
        $datosenvio->telefono = $request->telefono;
        $datosenvio->email = $request->email;
        $datosenvio->rfc = $request->rfc;
        $datosenvio->referencia = $request->referencia;

        if ($datosenvio->save()) {
            $data = [
                "ok"      => true,
                "mensaje" => $msj,
                "id"      => $datosenvio->id
            ];
        } else {
            $data = [
                "ok" => false
            ];
        }

        echo json_encode($data);

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
