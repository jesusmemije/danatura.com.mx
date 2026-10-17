<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\DudasComentarios;
use App\Mail\MensajeContacto;
use App\Models\Contacto;
use App\Models\DatosEnvio;
use App\Models\Productos;
use App\Models\Rule;
use App\Models\User;
use Carbon\Carbon;
// Send mail
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {

        $descuento_envio = DB::table('rules')
            ->select('rules.*')
            ->where('id', '=', 1)
            ->get();

        $descuento_final = 0;
        if (count($descuento_envio) == 0) {
            // code...
        } else {
            $descuento_final = $descuento_envio[0]->cantidad;
        }

        // dd($descuento_final);

        $masvendidos =
            DB::table('compra_item')
                ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
                ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,fotografia,galeria')
                ->orderByRaw('sum(cantidad) desc ')
                ->select('productos.id', 'productos.nuevo', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'productos.precio_mayorista', 'productos.precio_nutriologo', 'fotografia', 'galeria')
                ->where('productos.status', 1)
                ->where('productos.idioma', 'es')
                ->limit(6)
                ->get();

        $productos = Productos::where('status', 1)->get();
        // dd('estamos en mantenimiento');

        return view('front/home', ['masvendidos' => $masvendidos, 'productos' => $productos, 'descuento_final' => $descuento_final]);
    }

    public function index_en()
    {
        $masvendidos =
            DB::table('compra_item')
                ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
                ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,fotografia,galeria')
                ->orderByRaw('sum(cantidad) desc ')
                ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'productos.precio_mayorista', 'productos.precio_nutriologo', 'fotografia', 'galeria')
                ->where('productos.status', 1)
                ->where('productos.idioma', 'en')
                ->limit(6)
                ->get();

        $productos = Productos::where('status', 1)->get();

        return view('front/en/home_en', ['masvendidos' => $masvendidos, 'productos' => $productos]);
    }

    public function registrar_contacto(Request $request)
    {

        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = '6Ldp7NIgAAAAAIFXHSdin_P2_VRDJqCyeZ-gP_i9';

        $repuesta_captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

        $consultar = json_decode($repuesta_captcha, true);

        if (! $consultar['success']) {
            return redirect()->back()->with('error', 'Por favor valida el captha.');
        }

        $contacto = new Contacto;
        $contacto->nombre = $request->nombre;
        $contacto->email = $request->email;
        $contacto->asunto = $request->asunto;
        $contacto->mensaje = $request->mensaje;

        Mail::to('contacto@danatura.com.mx')->send(new MensajeContacto($contacto));

        if ($contacto->save()) {
            return redirect()->back()->with('mensaje', 'Su información se ha enviado a nuestro equipo de trabajo.');
        } else {
            return redirect()->back()->with('error', 'Su información no ha podido ser enviada, intentelo de nuevo.');
        }
    }

    public function registrar_contacto_en(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = '6Ldp7NIgAAAAAIFXHSdin_P2_VRDJqCyeZ-gP_i9';

        $repuesta_captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

        $consultar = json_decode($repuesta_captcha, true);

        if (! $consultar['success']) {
            return redirect()->back()->with('error', 'Please validate the captha.');
        }

        $contacto = new Contacto;
        $contacto->nombre = $request->nombre;
        $contacto->email = $request->email;
        $contacto->asunto = $request->asunto;
        $contacto->mensaje = $request->mensaje;

        Mail::to('contacto@danatura.com.mx')->send(new MensajeContacto($contacto));

        if ($contacto->save()) {
            return redirect()->back()->with('mensaje', 'Your information has been sent to our team.');
        } else {
            return redirect()->back()->with('error', 'Your information could not be sent, please try again.');
        }
    }

    public function productos()
    {
        session_start();
        $_SESSION['thetotal'] = 0;

        $user = Auth::user();
        $categorias = DB::table('categorias')->get();
        // $productos = Productos::where('status', 1)->paginate(9);

        return view('front/productos', ['user' => $user, 'categorias' => $categorias]);
    }

    public function productos_en()
    {
        session_start();
        $_SESSION['thetotal'] = 0;

        $user = Auth::user();
        $categorias = DB::table('categorias')->get();
        // $productos = Productos::where('status', 1)->paginate(9);

        return view('front/en/productos_en', ['user' => $user, 'categorias' => $categorias]);
    }

    public function detalle_producto(Request $request)
    {
        $masvendidos =
        DB::table('compra_item')
            ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
            ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,precio_mayorista,precio_nutriologo,nuevo,fotografia,galeria')
            ->orderByRaw('sum(cantidad) desc ')
            ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'productos.precio_mayorista', 'nuevo', 'productos.precio_nutriologo', 'fotografia', 'galeria')
            ->where('productos.status', 1)
            ->where('productos.idioma', 'es')
            ->limit(6)
            ->get();

        $producto = Productos::where('nombre', $request->producto)->first();

        return view('front/detalle-producto', ['producto' => $producto, 'masvendidos' => $masvendidos]);
    }

    public function detalle_producto_en(Request $request)
    {

        $masvendidos =
        DB::table('compra_item')
            ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
            ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,precio_mayorista,precio_nutriologo,nuevo,fotografia,galeria')
            ->orderByRaw('sum(cantidad) desc ')
            ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.precio', 'productos.precio_mayorista', 'nuevo', 'productos.precio_nutriologo', 'fotografia', 'galeria')
            ->where('productos.status', 1)
            ->where('productos.idioma', 'en')
            ->limit(6)
            ->get();

        $producto = Productos::where('nombre', $request->product)->first();

        return view('front/en/detalle-producto_en', ['producto' => $producto, 'masvendidos' => $masvendidos]);
    }

    public function puntos_venta(Request $request)
    {
        $productos = Productos::where('status', 1)->get();

        $estado = $request->estado;
        $ciudad = $request->ciudad;
        $busqueda = $request->busqueda;

        if ($estado != '' || $ciudad != '' || $busqueda != '') {

            $puntos = DB::table('puntos_ventas')
                ->where('estado', 'like', '%'.$estado.'%')
                ->where('ciudad', 'like', '%'.$ciudad.'%')

                ->get();
        } else {
            $puntos = DB::table('puntos_ventas')->get();
        }

        if ($busqueda != '') {
            $puntos = DB::table('puntos_ventas')
                ->orWhere('estado', 'like', '%'.$busqueda.'%')
                ->orWhere('ciudad', 'like', '%'.$busqueda.'%')
                ->orWhere('nombre_comercial', 'like', '%'.$busqueda.'%')
                ->orWhere('direccion', 'like', '%'.$busqueda.'%')
                ->get();
        }

        return view('front/puntos-venta', ['puntos' => $puntos, 'productos' => $productos]);
    }

    public function puntos_venta_en(Request $request)
    {
        $productos = Productos::where('status', 1)->get();

        $estado = $request->estado;
        $ciudad = $request->ciudad;
        $busqueda = $request->busqueda;

        if ($estado != '' || $ciudad != '' || $busqueda != '') {

            $puntos = DB::table('puntos_ventas')
                ->where('estado', 'like', '%'.$estado.'%')
                ->where('ciudad', 'like', '%'.$ciudad.'%')

                ->get();
        } else {
            $puntos = DB::table('puntos_ventas')->get();
        }

        if ($busqueda != '') {
            $puntos = DB::table('puntos_ventas')
                ->orWhere('estado', 'like', '%'.$busqueda.'%')
                ->orWhere('ciudad', 'like', '%'.$busqueda.'%')
                ->orWhere('nombre_comercial', 'like', '%'.$busqueda.'%')
                ->orWhere('direccion', 'like', '%'.$busqueda.'%')
                ->get();
        }

        return view('front/en/puntos-venta_en', ['puntos' => $puntos, 'productos' => $productos]);
    }

    public function registro_normal(Request $request)
    {
        $usuario = User::create([
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'tipo' => 2,
            'password' => Hash::make($request['password']),
        ])->save();

        return redirect()->route('home');
    }

    public function filtrar_puntos(Request $request)
    {
        $estado = $request->estado;
        $ciudad = $request->ciudad;
        $buscador = $request->buscador;

        $puntos = DB::table('puntos_ventas')
            ->where('estado', 'like', '%'.$estado.'%')
            ->where('ciudad', 'like', '%'.$ciudad.'%')

            ->get();

        return view('front/puntos-venta', ['puntos' => $puntos]);
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

        if (! empty($existe)) {
            $response = ['mensaje' => 'ya existe'];
            echo json_encode($response);
            exit();
        }

        $hecho = DB::table('newsletter_subs')->insert([
            'correo' => $request->correo,
        ]);

        if ($hecho) {
            $response = ['mensaje' => 'bien'];
            echo json_encode($response);
        }
    }

    public function dudas(Request $request)
    {
        // dd('jb');
        if ($request->duda == '' || empty($request->duda) || $request->correo == '' || empty($request->correo)) {
            return redirect()->back()->with('error', 'mal');
            exit();
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = '6Ldp7NIgAAAAAIFXHSdin_P2_VRDJqCyeZ-gP_i9';

        $repuesta_captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

        $consultar = json_decode($repuesta_captcha, true);

        if (! $consultar['success']) {
            return redirect()->back()->with('error', 'Porfavor valida el captcha');
        }

        $hecho = DB::table('dudas_comentarios')->insert([
            'duda_comentario' => $request->nombre.' - '.$request->duda,
            'correo' => $request->correo,
            'fecha' => Carbon::now(),
        ]);

        $contacto = new Contacto;
        $contacto->nombre = $request->nombre;
        $contacto->email = $request->correo;
        $contacto->asunto = 'DUDAS Y COMENTARIOS';
        $contacto->mensaje = $request->duda;

        Mail::to('contacto@danatura.com.mx')->send(new DudasComentarios($contacto));
        // Mail::to('pablodiazorgin@gmail.com')->send(new DudasComentarios($contacto));

        if ($hecho) {
            $response = ['mensaje' => 'bien'];

            return redirect()->back()->with('mensaje', 'bien');
        } else {
            $response = ['mensaje' => 'mal'];

            return redirect()->back()->with('error', 'mal');
        }

    }

    public function filtrar_productos(Request $request)
    {
        if ($request->ajax()) {

            $tipo_precio = 'normal';
            $precio_normal = '';

            if (auth()->user() != null) {

                $tipo = auth()->user()->tipo;

                $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

                $thetipo = $tipos->tipo;

                if ($thetipo == 'Mayorista') {

                    $tipo_precio = 'mayorista';
                }
                if ($thetipo == 'Nutriologo') {

                    $tipo_precio = 'nutriologo';
                }
            }

            $data = DB::table('productos')
                ->join('categoriasproductos as cp', 'productos.id', '=', 'cp.id_producto')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('zona_producto')
                        ->whereColumn('zona_producto.id_producto', 'productos.id');
                })
                ->where('cp.id_categoria', '=', $request->id)
                ->where('productos.idioma', 'es')
                ->where('productos.status', 1)
                ->get();

            // $data = DB::table('productos')
            //     ->join('categoriasproductos as cp', 'productos.id', '=', 'cp.id_producto')
            //     ->where('cp.id_categoria', '=', $request->id)
            //     ->get();

            $thespan = '';
            $output = '';
            $hayono = '';

            if (! $data->isEmpty()) {
                foreach ($data as $row) {

                    $nombre = $row->nombre;

                    $fotografia = $row->fotografia;
                    $source = $fotografia;
                    if ($fotografia == '') {
                        $source = asset('assets/productos/goldenmilk.png');
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset('assets/productos').'/'.$fotografia;
                    }

                    if (strpos($row->precio, '.') !== false) {

                        $precio = $row->precio;
                    } else {
                        $precio = $row->precio.'.00';
                    }

                    // Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio.'.00';
                    }

                    if ($row->nuevo == 0) {
                        $nuevo_p = '<div style="height: 70px"></div>';
                    } elseif ($row->nuevo == 1) {
                        $nuevo_p = '<span class="nuevo-circle">New</span>';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' MXN</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="detalle-producto?producto='.$nombre.'">COMPRAR</a>
                    </div>';

                    $output .= '
                    <div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            '.$nuevo_p.'
                            <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                            <a  href="detalle-producto?producto='.$nombre.'">
                            <img class="img-thumbnail" src="'.$foto_principal.'" alt="">
                            </a>
                            <br>
                            <div style="padding:4%;">
                            <a  href="detalle-producto?producto='.$nombre.'">
                                <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br>
                                </a>
                                <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                '.$thespan.'
                                <br>
                                '.$hayono.'
                            </div>
                            </div>
                        </li>
                    </div>';
                }
                echo $output;
            }
        }
    }

    public function filtrar_productos_en(Request $request)
    {
        if ($request->ajax()) {

            $tipo_precio = 'normal';
            $precio_normal = '';

            if (auth()->user() != null) {

                $tipo = auth()->user()->tipo;

                $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

                $thetipo = $tipos->tipo;

                if ($thetipo == 'Mayorista') {

                    $tipo_precio = 'mayorista';
                }
                if ($thetipo == 'Nutriologo') {

                    $tipo_precio = 'nutriologo';
                }
            }

            $data = DB::table('productos')
                ->join('categoriasproductos as cp', 'productos.id', '=', 'cp.id_producto')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('zona_producto')
                        ->whereColumn('zona_producto.id_producto', 'productos.id');
                })
                ->where('cp.id_categoria', '=', $request->id)
                ->where('productos.idioma', 'en')
                ->where('productos.status', 1)
                ->get();

            // $data = DB::table('productos')
            //     ->join('categoriasproductos as cp', 'productos.id', '=', 'cp.id_producto')
            //     ->where('cp.id_categoria', '=', $request->id)
            //     ->get();

            $thespan = '';
            $output = '';
            $hayono = '';

            if (! $data->isEmpty()) {
                foreach ($data as $row) {

                    $nombre = $row->nombre;

                    $fotografia = $row->fotografia;
                    $source = $fotografia;
                    if ($fotografia == '') {
                        $source = asset('assets/productos/goldenmilk.png');
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset('assets/productos').'/'.$fotografia;
                    }

                    if (strpos($row->precio, '.') !== false) {

                        $precio = $row->precio;
                    } else {
                        $precio = $row->precio.'.00';
                    }

                    // Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' USD</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' USD</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' USD</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' USD</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' USD</span>';
                    }

                    if ($row->nuevo == 0) {
                        $nuevo_p = '<div style="height: 70px"></div>';
                    } elseif ($row->nuevo == 1) {
                        $nuevo_p = '<span class="nuevo-circle">New</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="detalle-producto?producto='.$nombre.'">BUY</a>
                    </div>';

                    $output .= '
                    <div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            '.$nuevo_p.'
                            <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                            <a  href="detalle-producto?producto='.$nombre.'">
                            <img class="img-thumbnail" src="'.$foto_principal.'" alt="">
                            </a>
                            <br>
                            <div style="padding:4%;">
                            <a  href="detalle-producto?producto='.$nombre.'">
                                <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br>
                                </a>
                                <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                '.$thespan.'
                                <br>
                                '.$hayono.'
                            </div>
                            </div>
                        </li>
                    </div>';
                }
                echo $output;
            }
        }
    }

    public function load_more(Request $request)
    {
        session_start();

        $aux_seg = 0;

        $count = DB::table('productos')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('zona_producto')
                    ->whereColumn('zona_producto.id_producto', 'productos.id');
            })
        //    ->orderBy('nombre','asc')
            ->where('productos.idioma', 'es')
            ->where('status', 1)
            ->get()->count();

        // $count = Productos::where('status', 1)->get()->count();

        $tipo_precio = 'normal';
        $precio_normal = '';

        if (auth()->user() != null) {

            $tipo = auth()->user()->tipo;
            $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

            $thetipo = $tipos->tipo;

            if ($thetipo == 'Mayorista') {
                $tipo_precio = 'mayorista';
            }
            if ($thetipo == 'Nutriologo') {
                $tipo_precio = 'nutriologo';
            }
        }

        if ($request->ajax()) {
            if ($request->id > 0) {
                $data = DB::table('productos')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('zona_producto')
                            ->whereColumn('zona_producto.id_producto', 'productos.id');
                    })
                    ->where('id', '<', $request->id)
                    ->where('idioma', 'es')
                    ->where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->limit(9)
                    ->get();

                // $data = DB::table('productos')
                //     ->where('id', '<', $request->id)
                //     ->where('status', 1)
                //     ->orderBy('id', 'DESC')
                //     ->limit(9)
                //     ->get();
            } else {
                $data = DB::table('productos')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('zona_producto')
                            ->whereColumn('zona_producto.id_producto', 'productos.id');
                    })
                    ->where('status', 1)
                    ->where('idioma', 'es')
                    ->orderBy('id', 'DESC')
                    ->limit(9)
                    ->get();

                // $data = DB::table('productos')
                //     ->where('status', 1)
                //     ->orderBy('id', 'DESC')
                //     ->limit(9)
                //     ->get();
            }

            $thespan = '';
            $output = '';
            $hayono = '';
            $last_id = '';
            $nuevo_p = '';

            if (! $data->isEmpty()) {

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
                    if ($fotografia == '') {
                        $source = asset('assets/productos/goldenmilk.png');
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset('assets/productos').'/'.$fotografia;
                    }

                    // Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' MXN</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                    }

                    if ($row->nuevo == 0) {
                        $nuevo_p = '<div style="height: 70px"></div>';
                    } elseif ($row->nuevo == 1) {
                        $nuevo_p = '<span class="nuevo-circle">Nuevo</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="detalle-producto?producto='.$nombre.'">COMPRAR</a>
                    </div>';

                    $output .= '<div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            '.$nuevo_p.'
                            <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                            <a  href="detalle-producto?producto='.$nombre.'">
                            <img class="img-thumbnail" src="'.$foto_principal.'" alt=""> </a>
                            <br>
                            <div style="padding:4%;">
                                <a  href="detalle-producto?producto='.$nombre.'">
                                    <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br> </a>
                                    <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                    '.$thespan.'
                                    <br>

                                    '.$hayono.'

                                </div>
                            </div>
                        </li>
                    </div>';

                    $last_id = $row->id;
                }

                $output .=
                    '<div id="showpp" class="col-md-12 d-flex justify-content-center" style="color:#73472b; font-weight:520;">
                    <span>MOSTRANDO '.$aux_seg.' de '.$count.' productos</span>
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
                        <div style="'.$progress_with.'"></div>
                    </div>
                </div>';

                $output .=
                    '<div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar" data-id="'.$last_id.'" id="load_more_button" >CARGAR MÁS PRODUCTOS</a>
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

    public function load_more_en(Request $request)
    {
        session_start();

        $aux_seg = 0;

        $count = DB::table('productos')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('zona_producto')
                    ->whereColumn('zona_producto.id_producto', 'productos.id');
            })
            ->where('idioma', '=', 'en')
            ->where('status', 1)
            ->get()->count();

        $tipo_precio = 'normal';
        $precio_normal = '';

        if (auth()->user() != null) {

            $tipo = auth()->user()->tipo;
            $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

            $thetipo = $tipos->tipo;

            if ($thetipo == 'Mayorista') {
                $tipo_precio = 'mayorista';
            }
            if ($thetipo == 'Nutriologo') {
                $tipo_precio = 'nutriologo';
            }
        }

        if ($request->ajax()) {
            if ($request->id > 0) {
                $data = DB::table('productos')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('zona_producto')
                            ->whereColumn('zona_producto.id_producto', 'productos.id');
                    })
                    ->where('id', '<', $request->id)
                    ->where('idioma', '=', 'en')
                    ->where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->limit(9)
                    ->get();
            } else {
                $data = DB::table('productos')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('zona_producto')
                            ->whereColumn('zona_producto.id_producto', 'productos.id');
                    })
                    ->where('status', 1)
                    ->where('idioma', '=', 'en')
                    ->orderBy('id', 'DESC')
                    ->limit(9)
                    ->get();
            }

            $thespan = '';
            $output = '';
            $hayono = '';
            $last_id = '';

            if (! $data->isEmpty()) {

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
                    if ($fotografia == '') {
                        $source = asset('assets/productos/goldenmilk.png');
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset('assets/productos').'/'.$fotografia;
                    }

                    // Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' USD</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' USD</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' USD</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' USD</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' USD</span>';
                    }

                    if ($row->nuevo == 0) {
                        $nuevo_p = '<div style="height: 70px"></div>';
                    } elseif ($row->nuevo == 1) {
                        $nuevo_p = '<span class="nuevo-circle">New</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="products-detail?product='.$nombre.'">BUY</a>
                    </div>';

                    $output .= '<div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            '.$nuevo_p.'
                            <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                            <a  href="products-detail?product='.$nombre.'">
                            <img class="img-thumbnail" src="'.$foto_principal.'" alt=""> </a>
                            <br>
                            <div style="padding:4%;">
                                <a  href="products-detail?product='.$nombre.'">
                                    <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br> </a>
                                    <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                    '.$thespan.'
                                    <br>

                                    '.$hayono.'

                                </div>
                            </div>
                        </li>
                    </div>';

                    $last_id = $row->id;
                }

                $output .=
                    '<div id="showpp" class="col-md-12 d-flex justify-content-center" style="color:#73472b; font-weight:520;">
                    <span>SHOWING '.$aux_seg.' of '.$count.' products</span>
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
                        <div style="'.$progress_with.'"></div>
                    </div>
                </div>';

                $output .=
                    '<div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar" data-id="'.$last_id.'" id="load_more_button" >LOAD MORE PRODUCTS</a>
                </div>';
            } else {

                $output .= '
                <div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar">There are no more products</a>
                </div>';
            }

            echo $output;
        }
    }

    public function misfavoritos()
    {
        if (isset($_COOKIE['thecookie']) && $_COOKIE['thecookie'] != '') {

            $cke = explode(',', $_COOKIE['thecookie']);

            $misfavoritos = Productos::whereIn('id', $cke)->get();

            return view('front/mis-favoritos', ['favoritos' => $misfavoritos]);
        } else {

            $masvendidos =
            DB::table('compra_item')
                ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
                ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,precio_nutriologo,precio_mayorista,nuevo,fotografia,galeria')
                ->orderByRaw('sum(cantidad) desc ')
                ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.nuevo', 'productos.precio', 'productos.precio_nutriologo', 'productos.precio_mayorista', 'fotografia', 'galeria')
                ->where('productos.status', 1)
                ->where('productos.idioma', 'es')
                ->limit(6)
                ->get();

            return redirect()->route('home', ['masvendidos' => $masvendidos]);
        }
    }

    public function misfavoritos_en()
    {

        if (isset($_COOKIE['thecookie']) && $_COOKIE['thecookie'] != '') {

            $cke = explode(',', $_COOKIE['thecookie']);

            $misfavoritos = Productos::whereIn('id', $cke)->get();

            return view('front/en/mis-favoritos_en', ['favoritos' => $misfavoritos]);
        } else {

            $masvendidos =
            DB::table('compra_item')
                ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
                ->groupByRaw('id,nombre,sabor,descripcion,gramos,precio,precio_nutriologo,precio_mayorista,nuevo,fotografia,galeria')
                ->orderByRaw('sum(cantidad) desc ')
                ->select('productos.id', 'productos.nombre', 'sabor', 'descripcion', 'gramos', 'productos.nuevo', 'productos.precio', 'productos.precio_nutriologo', 'productos.precio_mayorista', 'fotografia', 'galeria')
                ->where('productos.status', 1)
                ->where('productos.idioma', 'en')
                ->limit(6)
                ->get();

            return redirect()->route('home_en', ['masvendidos' => $masvendidos]);
        }
    }

    public function carrito()
    {
        $rule = Rule::find(1);
        // dd($rule);

        return view('front.carrito', compact('rule'));
    }

    public function carrito_en()
    {
        $rule = Rule::find(2);

        return view('front.en.carrito_en', compact('rule'));
    }

    public function procesa()
    {
        session_start();

        if (isset($_POST['cantidad'])) {
            if ($_POST['cantidad'] <= 0) {
                $respuesta = ['operacion' => 'zero'];
                echo json_encode($respuesta);
                exit();
            }
        }

        if (isset($_SESSION['totalpagar']) && isset($_SESSION['descuentoCupon'])) {
            $_SESSION['totalpagar'] = $_SESSION['totalpagar'] + $_SESSION['descuentoCupon'];
            unset($_SESSION['descuentoCupon']);
        }

        if (isset($_POST['id'])) {

            $producto = Productos::find($_POST['id']);

            if ($producto->stock < $_POST['cantidad']) {
                $respuesta = ['operacion' => 'excede', 'cantidad' => $producto->stock];
                echo json_encode($respuesta);
                exit();
            }

            $producto_id = $_POST['id'];
            $cantidad = $_POST['cantidad'];
            $nombre = $producto->nombre;
            $precio = $producto->precio;

            // Para verificar si ya existe un ID de producto dentro del carrito.
            if (isset($_SESSION['carrito'])) {

                // Cuando ya existe el carrito,  y quiere agregar más productos que se en total supere el stock.
                $aux_cantidad_total = 0;
                $auxCarrito = [];
                $auxCarrito = $_SESSION['carrito'];

                $existe = false;
                foreach ($auxCarrito as $key => $value) {
                    $aux_cantidad_total = $aux_cantidad_total + $value['cantidad'];

                    if ($producto_id == $value['producto_id']) {
                        $existe = true;
                    }
                }

                $aux_cantidad_total = $aux_cantidad_total + $_POST['cantidad'];

                if ($aux_cantidad_total > $producto->stock) {

                    $respuesta = ['operacion' => 'excede', 'cantidad' => $producto->stock - $aux_cantidad_total];
                    echo json_encode($respuesta);
                    exit();
                }

                if (! $existe) {
                    array_push($auxCarrito, ['producto_id' => $producto_id, 'nombre' => $nombre, 'precio_unit' => $precio, 'cantidad' => $cantidad]);

                    $respuesta = ['operacion' => 'bien'];
                    echo json_encode($respuesta);
                } else {
                    $respuesta = ['operacion' => 'doble'];
                    echo json_encode($respuesta);
                }

                $_SESSION['carrito'] = $auxCarrito;
            } else {
                // Cuando no hay registros previos de ese producto.
                $carrito = [];
                array_push($carrito, ['producto_id' => $producto_id, 'nombre' => $nombre, 'precio_unit' => $precio, 'cantidad' => $cantidad]);

                $_SESSION['carrito'] = $carrito;
                // echo sizeof($carrito);
                $respuesta = ['operacion' => 'bien'];
                echo json_encode($respuesta);
            }
        }

        if (isset($_POST['remove'])) {
            $producto_id = $_POST['remove'];

            if (isset($_SESSION['carrito'])) {

                $auxCarrito = $_SESSION['carrito'];

                for ($i = 0; $i < count($auxCarrito); $i++) {
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
        // Para verificar que el usuario solamente está cambiando su dirección de envio y "proteger" los otros datos.
        if (! empty($request->dato_id)) {
            $msj = 'Los datos se actualizaron correctamente';
            $datosenvio = DatosEnvio::find($request->dato_id);
        } else {
            $msj = 'Los datos se guardaron correctamente';
            $datosenvio = new DatosEnvio;
        }

        $id_user = 0;
        if (! empty($request->id_user)) {
            $id_user = $request->id_user;
        } else {
            $id_user = Auth::user()->id;
        }

        $datosenvio->id_user = $id_user;
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
                'ok' => true,
                'mensaje' => $msj,
                'id' => $datosenvio->id,
            ];
        } else {
            $data = [
                'ok' => false,
            ];
        }

        echo json_encode($data);

    }

    public function datos_envio_en(Request $request)
    {
        // Para verificar que el usuario solamente está cambiando su dirección de envio y "proteger" los otros datos.
        if (! empty($request->dato_id)) {
            $msj = 'The data was updated successfully';
            $datosenvio = DatosEnvio::find($request->dato_id);
        } else {
            $msj = 'The data was saved successfully';
            $datosenvio = new DatosEnvio;
        }

        $id_user = 0;
        if (! empty($request->id_user)) {
            $id_user = $request->id_user;
        } else {
            $id_user = Auth::user()->id;
        }

        $datosenvio->id_user = $id_user;
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
                'ok' => true,
                'mensaje' => $msj,
                'id' => $datosenvio->id,
            ];
        } else {
            $data = [
                'ok' => false,
            ];
        }

        echo json_encode($data);

    }

    public function logout($idioma)
    {
        if ($idioma == 'es') {
            Auth::logout();

            return redirect('/');
            // code...
        } elseif ($idioma == 'en') {
            Auth::logout();

            return redirect('/_en');
        }

    }

    public function resultados_busqueda(Request $request)
    {

        $palabra_busqueda = $request->input_busqueda;
        $aux_seg = 0;

        $count = Productos::where('status', 1)->get()->count();

        $tipo_precio = 'normal';
        $precio_normal = '';

        if (auth()->user() != null) {

            $tipo = auth()->user()->tipo;
            $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

            $thetipo = $tipos->tipo;

            if ($thetipo == 'Mayorista') {
                $tipo_precio = 'mayorista';
            }
            if ($thetipo == 'Nutriologo') {
                $tipo_precio = 'nutriologo';
            }
        }

        $data_producto = DB::table('productos')
            ->where('nombre', 'like', '%'.$request->input_busqueda.'%')
            ->orwhere('descripcion', 'like', '%'.$request->input_busqueda.'%')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->where('idioma', '=', 'es')
            // ->limit(9)
            ->get();
        $data = [];

        if (count($data_producto) == 0) {

        } else {

            foreach ($data_producto as $dat) {
                $zona_producto = DB::table('zona_producto')
                    ->where('zona_producto.id_producto', '=', $dat->id)
                    ->get();

                if (count($zona_producto) == 0) {
                    array_push($data, [
                        'id' => $dat->id,
                        'nombre' => $dat->nombre,
                        'sabor' => $dat->sabor,
                        'descripcion' => $dat->descripcion,
                        'gramos' => $dat->gramos,
                        'precio' => $dat->precio,
                        'precio_mayorista' => $dat->precio_mayorista,
                        'precio_nutriologo' => $dat->precio_nutriologo,
                        'stock' => $dat->stock,
                        'categoria' => $dat->categoria,
                        'fotografia' => $dat->fotografia,
                        'nuevo' => $dat->nuevo,
                        'idioma' => $dat->idioma,
                        'galeria' => $dat->galeria,
                        'status' => $dat->status,
                        'created_at' => $dat->created_at,
                        'updated_at' => $dat->updated_at,
                    ]);
                } else {

                }

            }
        }
        $data = json_encode($data);
        $data = json_decode($data);

        $thespan = '';
        $output = '';
        $hayono = '';
        $last_id = '';
        $nuevo_p = '';

        if (! empty($data)) {

            foreach ($data as $row) {

                if ($row->idioma == 'en') {
                    // code...
                } elseif ($row->idioma == 'es') {

                    $nombre = $row->nombre;
                    $fotografia = $row->fotografia;
                    $source = $fotografia;
                    if ($fotografia == '') {
                        $source = asset('assets/productos/goldenmilk.png');
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset('assets/productos').'/'.$fotografia;
                    }

                    // Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' MXN</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                            <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                            <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    if ($row->nuevo == 0) {
                        $nuevo_p = '<div style="height: 70px"></div>';
                    } elseif ($row->nuevo == 1) {
                        $nuevo_p = '<span class="nuevo-circle">Nuevo</span>';
                    }

                    $hayono = '<div class="d-flex justify-content-end">
                            <a class="btn btn-secondary comprar"  href="detalle-producto?producto='.$nombre.'">COMPRAR</a>
                        </div>';

                    $output .= '<div class="col-md-4 spc">
                            <li style="">
                                <div  style="padding:2%;">
                                '.$nuevo_p.'
                                <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                                <a  href="detalle-producto?producto='.$nombre.'">
                                <img class="img-thumbnail" src="'.$foto_principal.'" alt=""> </a>
                                <br>
                                <div style="padding:4%;">
                                    <a  href="detalle-producto?producto='.$nombre.'">
                                        <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br> </a>
                                        <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                        '.$thespan.'
                                        <br>

                                        '.$hayono.'

                                    </div>
                                </div>
                            </li>
                        </div>';

                    $last_id = $row->id;
                }
            }

        } else {

            $output .= '
                <div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar">No hay productos</a>
                </div>';
        }

        return view('front.resultados_busqueda', ['output' => $output, 'palabra_busqueda' => $palabra_busqueda]);
    }

    public function resultados_busqueda_en(Request $request)
    {

        $palabra_busqueda = $request->input_busqueda;
        $aux_seg = 0;

        $count = Productos::where('status', 1)->get()->count();

        $tipo_precio = 'normal';
        $precio_normal = '';

        if (auth()->user() != null) {

            $tipo = auth()->user()->tipo;
            $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

            $thetipo = $tipos->tipo;

            if ($thetipo == 'Mayorista') {
                $tipo_precio = 'mayorista';
            }
            if ($thetipo == 'Nutriologo') {
                $tipo_precio = 'nutriologo';
            }
        }

        $data_producto = DB::table('productos')
            ->where('nombre', 'like', '%'.$request->input_busqueda.'%')
            ->orwhere('descripcion', 'like', '%'.$request->input_busqueda.'%')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->where('idioma', '=', 'en')
            // ->limit(9)
            ->get();
        $data = [];

        if (count($data_producto) == 0) {

        } else {

            foreach ($data_producto as $dat) {
                $zona_producto = DB::table('zona_producto')
                    ->where('zona_producto.id_producto', '=', $dat->id)
                    ->get();

                if (count($zona_producto) == 0) {
                    array_push($data, [
                        'id' => $dat->id,
                        'nombre' => $dat->nombre,
                        'sabor' => $dat->sabor,
                        'descripcion' => $dat->descripcion,
                        'gramos' => $dat->gramos,
                        'precio' => $dat->precio,
                        'precio_mayorista' => $dat->precio_mayorista,
                        'precio_nutriologo' => $dat->precio_nutriologo,
                        'stock' => $dat->stock,
                        'categoria' => $dat->categoria,
                        'fotografia' => $dat->fotografia,
                        'nuevo' => $dat->nuevo,
                        'idioma' => $dat->idioma,
                        'galeria' => $dat->galeria,
                        'status' => $dat->status,
                        'created_at' => $dat->created_at,
                        'updated_at' => $dat->updated_at,
                    ]);
                } else {

                }

            }
        }
        $data = json_encode($data);
        $data = json_decode($data);

        $thespan = '';
        $output = '';
        $hayono = '';
        $last_id = '';
        $nuevo_p = '';

        if (! empty($data)) {

            foreach ($data as $row) {

                if ($row->idioma == 'es') {
                    // code...
                } elseif ($row->idioma == 'en') {

                    $nombre = $row->nombre;
                    $fotografia = $row->fotografia;
                    $source = $fotografia;
                    if ($fotografia == '') {
                        $source = asset('assets/productos/goldenmilk.png');
                    }

                    if (strpos($source, 'https') !== false) {
                        $source = $source;
                    } else {
                        $source = asset('assets/productos').'/'.$fotografia;
                    }

                    // Para los precios.
                    if (strpos($row->precio, '.') !== false) {
                        $precio_normal = $row->precio;
                    } else {
                        $precio_normal = $row->precio.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' USD</span>';

                    if ($tipo_precio == 'mayorista') {

                        if (strpos($row->precio_mayorista, '.') !== false) {
                            $precio = $row->precio_mayorista;
                        } else {
                            $precio = $row->precio_mayorista.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' USD</span>
                            <span style="color:#73472b; font-weight: bold;">$'.$precio.' USD</span>';
                    }

                    if ($tipo_precio == 'nutriologo') {
                        if (strpos($row->precio_nutriologo, '.') !== false) {
                            $precio = $row->precio_nutriologo;
                        } else {
                            $precio = $row->precio_nutriologo.'.00';
                        }

                        $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' USD</span>
                            <span style="color:#73472b; font-weight: bold;">$'.$precio.' USD</span>';
                    }

                    $array_galeria = explode('|', $row->galeria);

                    $foto_principal = $array_galeria[0];

                    if ($row->nuevo == 0) {
                        $nuevo_p = '<div style="height: 70px"></div>';
                    } elseif ($row->nuevo == 1) {
                        $nuevo_p = '<span class="nuevo-circle">New</span>';
                    }

                    $hayono = '<div class="d-flex justify-content-end">
                            <a class="btn btn-secondary comprar"  href="products-detail?product='.$nombre.'">BUY</a>
                        </div>';

                    $output .= '<div class="col-md-4 spc">
                            <li style="">
                                <div  style="padding:2%;">
                                '.$nuevo_p.'
                                <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                                <a  href="products-detail?product='.$nombre.'">
                                <img class="img-thumbnail" src="'.$foto_principal.'" alt=""> </a>
                                <br>
                                <div style="padding:4%;">
                                    <a  href="products-detail?product='.$nombre.'">
                                        <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br> </a>
                                        <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                        '.$thespan.'
                                        <br>

                                        '.$hayono.'

                                    </div>
                                </div>
                            </li>
                        </div>';

                    $last_id = $row->id;
                }
            }

        } else {

            $output .= '
                <div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
                    <a class="btn btn-secondary cargar">No hay productos</a>
                </div>';
        }

        return view('front.en.resultados_busqueda_en', ['output' => $output, 'palabra_busqueda' => $palabra_busqueda]);
    }

    public function venta_zona(Request $request)
    {

        $zona = DB::table('venta_zonas')
            ->where('id', '=', $request->id_zona)
            ->get();

        if (count($zona) == 0) {
            $nombre_zona = '';

        } else {
            $nombre_zona = $zona[0]->nombre_zona;
        }

        if (Auth::check()) {
            $pregunta = DB::table('venta_zonas')
                ->join('zona_usuario', 'venta_zonas.id', 'zona_usuario.id_zona_venta')
                ->join('users', 'zona_usuario.id_usuario', 'users.id')
                ->select('venta_zonas.nombre_zona', 'venta_zonas.descripcion_zona', 'venta_zonas.id', 'zona_usuario.id as id_zona_usuario')
                ->where('zona_usuario.id_usuario', '=', Auth::user()->id)
                ->where('venta_zonas.id', '=', $request->id_zona)
                ->get();

            if (count($pregunta) == 0) {
                return redirect('/');
            } else {

                return view('front.zona_venta_productos', ['id_zona' => $request->id_zona, 'nombre_zona' => $nombre_zona]);
            }
        }

        return redirect('/login');
    }

    public function venta_zona_productos(Request $request)
    {

        session_start();

        $aux_seg = 0;

        $count = Productos::where('status', 1)->get()->count();

        $count = DB::table('venta_zonas')
            ->join('zona_producto', 'venta_zonas.id', 'zona_producto.id_zona_venta')
            ->join('productos', 'zona_producto.id_producto', 'productos.id')
            ->select('productos.*', 'venta_zonas.nombre_zona', 'venta_zonas.id', 'zona_producto.id as id_zona_producto')
            ->where('venta_zonas.id', '=', $request->id_zona)
            ->where('productos.idioma', '=', 'es')
            ->orderBy('productos.id', 'DESC')
            ->get()->count();

        $tipo_precio = 'normal';
        $precio_normal = '';

        if (auth()->user() != null) {

            $tipo = auth()->user()->tipo;
            $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

            $thetipo = $tipos->tipo;

            if ($thetipo == 'Mayorista') {
                $tipo_precio = 'mayorista';
            }
            if ($thetipo == 'Nutriologo') {
                $tipo_precio = 'nutriologo';
            }
        }

        if ($request->ajax()) {

            $data = DB::table('venta_zonas')
                ->join('zona_producto', 'venta_zonas.id', 'zona_producto.id_zona_venta')
                ->join('productos', 'zona_producto.id_producto', 'productos.id')
                ->select('productos.*', 'venta_zonas.nombre_zona', 'venta_zonas.id', 'zona_producto.id as id_zona_producto')
                ->where('venta_zonas.id', '=', $request->id_zona)
                ->orderBy('productos.id', 'DESC')
                ->limit(9)
                ->get();

            $thespan = '';
            $output = '';
            $hayono = '';
            $last_id = '';

            // if (!$data->isEmpty()) {

            //     if (isset($_SESSION['thetotal'])) {

            //         if ($aux_seg < $count) {
            //             $aux_seg = $_SESSION['thetotal'] + 9;
            //             $_SESSION['thetotal'] = $aux_seg;

            //             if ($aux_seg >= $count) {
            //                 $aux_seg = $count;
            //             }
            //         } else {
            //             $aux_seg = $count;
            //         }
            //     } else {
            //         $_SESSION['thetotal'] = 0;
            //     }

            foreach ($data as $row) {

                $nombre = $row->nombre;
                $fotografia = $row->fotografia;
                $source = $fotografia;
                if ($fotografia == '') {
                    $source = asset('assets/productos/goldenmilk.png');
                }

                if (strpos($source, 'https') !== false) {
                    $source = $source;
                } else {
                    $source = asset('assets/productos').'/'.$fotografia;
                }

                // Para los precios.
                if (strpos($row->precio, '.') !== false) {
                    $precio_normal = $row->precio;
                } else {
                    $precio_normal = $row->precio.'.00';
                }

                $thespan = ' <span style="color:#73472b; font-weight: bold;">$'.$precio_normal.' MXN</span>';

                if ($tipo_precio == 'mayorista') {

                    if (strpos($row->precio_mayorista, '.') !== false) {
                        $precio = $row->precio_mayorista;
                    } else {
                        $precio = $row->precio_mayorista.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                }

                if ($tipo_precio == 'nutriologo') {
                    if (strpos($row->precio_nutriologo, '.') !== false) {
                        $precio = $row->precio_nutriologo;
                    } else {
                        $precio = $row->precio_nutriologo.'.00';
                    }

                    $thespan = ' <span style="color:#73472b; font-weight: bold; text-decoration:line-through;">$'.$precio_normal.' MXN</span>
                        <span style="color:#73472b; font-weight: bold;">$'.$precio.' MXN</span>';
                }

                $array_galeria = explode('|', $row->galeria);

                $foto_principal = $array_galeria[0];

                $hayono = '<div class="d-flex justify-content-end">
                        <a class="btn btn-secondary comprar"  href="detalle-producto?producto='.$nombre.'">COMPRAR</a>
                    </div>';

                $output .= '<div class="col-md-4 spc">
                        <li style="">
                            <div  style="padding:2%;">
                            <span class="nuevo-circle">Nuevo</span>
                            <i id="fav'.$row->id.'"  onclick="fav(this,'.$row->id.')" class="fas fa-heart corazon"></i>
                            <a  href="detalle-producto?producto='.$nombre.'">
                            <img class="img-thumbnail" src="'.$foto_principal.'" alt=""> </a>
                            <br>
                            <div style="padding:4%;">
                                <a  href="detalle-producto?producto='.$nombre.'">
                                    <span style="color:#73472b; font-family:AmasisMTStd-Bold;">'.$row->nombre.'</span><br> </a>
                                    <span style="color:#73472b; class="cls2" >'.$row->sabor.'</span><br>
                                    '.$thespan.'
                                    <br>

                                    '.$hayono.'

                                </div>
                            </div>
                        </li>
                    </div>
                    <br><br><br><br><br><br>';

                $last_id = $row->id;
            }

            // $output .=
            //     '<div id="showpp" class="col-md-12 d-flex justify-content-center" style="color:#73472b; font-weight:520;">
            //     <span>MOSTRANDO ' . $aux_seg . ' de ' . $count . ' productos</span>
            // </div>';

            // if ($aux_seg == 9) {
            //     $progress_with = 'width: 16.5%;';
            // } elseif ($aux_seg == 18) {
            //     $progress_with = 'width: 33%;';
            // } elseif ($aux_seg == 27) {
            //     $progress_with = 'width: 49.5%;';
            // } elseif ($aux_seg == 36) {
            //     $progress_with = 'width: 66%;';
            // } elseif ($aux_seg == 45) {
            //     $progress_with = 'width: 82.5%;';
            // } else {
            //     $progress_with = 'width: 100%;';
            // }

            // $output .=
            //     '<div id="showpro" class="col-md-3 divbar" style="margin-left: 38%;">
            //     <div id="progressbar">
            //         <div style="' . $progress_with . '"></div>
            //     </div>
            // </div>';

            // $output .=
            //     '<div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
            //     <a class="btn btn-secondary cargar" data-id="' . $last_id . '" id="load_more_button" >CARGAR MÁS PRODUCTOS</a>
            // </div>';
            // } else {

            //     $output .= '
            //     <div class="col-md-12  d-flex justify-content-center" style="padding-bottom:5%; padding-top:2%">
            //         <a class="btn btn-secondary cargar">No hay más productos</a>
            //     </div>';
            // }

            echo $output;
        }

    }

    public function duplicar()
    {
        $data = DB::table('productos')
            ->select('productos.*')
            ->where('status', '=', 1)
            ->get();

        // if(count($data)==0)
        // {

        // }else{
        //     $cont=0;
        //     foreach ($data as $da) {
        //         // $cont+=1;

        //         // if ($cont==1) {
        //         // } else {
        //             $producto = new Productos();

        //             $producto->nombre = $da->nombre;

        //             $producto->sabor = $da->sabor;

        //             $producto->descripcion = $da->descripcion;

        //             $producto->gramos = $da->gramos;

        //             $producto->precio = $da->precio;

        //             $producto->precio_mayorista = $da->precio_mayorista;

        //             $producto->precio_nutriologo = $da->precio_nutriologo;

        //             // $producto->fotografia= $url;

        //             $producto->galeria = $da->galeria;
        //             $producto->categoria = $da->categoria;
        //             $producto->fotografia = $da->fotografia;

        //             $producto->stock = $da->stock;
        //             $producto->status = $da->status;

        //             $producto->idioma = 'en';
        //             $producto->nuevo = $da->nuevo;
        //             $saved = $producto->save();

        //         // }

        //     }
        // }

        // $data_es = DB::table('categoriasproductos')
        //     ->select('productos.*')
        //     ->where('status','=',1)
        //     ->where('idioma','=','es')

        $data_en = DB::table('productos')
            ->join('categoriasproductos', 'productos.id', 'categoriasproductos.id_producto')
            ->select('productos.*', 'categoriasproductos.*')
            ->where('status', '=', 1)
            ->where('idioma', '=', 'en')
            ->where('categoriasproductos.id_categoria', '=', 1)
            ->distinct()
            ->get();

        dd($data_en);
    }

    public function idioma(Request $request)
    {
        session_start();

        if ($request->idioma == 'es') {
            unset($_SESSION['carrito']);
            unset($_SESSION['gastoEnvio']);
            unset($_SESSION['descuentoCupon']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['totalpagar']);

            return redirect('/');
        } elseif ($request->idioma == 'en') {
            unset($_SESSION['carrito']);
            unset($_SESSION['gastoEnvio']);
            unset($_SESSION['descuentoCupon']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['totalpagar']);

            return redirect('/_en');
        }

    }

    public function galeria()
    {

        return view('front.galeria');
    }

    public function galeria_en()
    {

        return view('front.en.galeria_en');
    }
}
