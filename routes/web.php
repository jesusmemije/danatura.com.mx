<?php

use Illuminate\Support\Facades\Route;
/* Class Front */
use App\Http\Controllers\front\HomeController as HomeControllerFront;
/* Class Admin */
use App\Http\Controllers\admin\ProductosController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VentasProductosController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\HomeController as HomeControllerAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front Routes
Route::get('/', [HomeControllerFront::class, 'index'])->name('home');
Route::get('/productos',[HomeControllerFront::class, 'productos'])->name('productos');
Route::post('/filtrar-productos',[HomeControllerFront::class, 'filtrar_productos']);
Route::get('/puntos-venta',[HomeControllerFront::class, 'puntos_venta'])->name('puntos-venta');
Route::get('/filtrar-puntos',[HomeControllerFront::class, 'filtrar_puntos'])->name('filtrar-puntos');
Route::get('/mis-favoritos',[HomeControllerFront::class, 'misfavoritos'])->name('mis-favoritos');
Route::get('/detalle-producto/{producto?}',[HomeControllerFront::class, 'detalle_producto'])->name('detalle-producto');
Route::get('/carrito',[HomeControllerFront::class, 'carrito'])->name('carrito');
Route::get('/checkout',[HomeControllerFront::class, 'checkout'])->name('checkout');
Route::post('/payment',[HomeControllerFront::class, 'payment'])->name('payment');
Route::post('/datos-envio',[HomeControllerFront::class, 'datos_envio'])->name('datos-envio');

Route::post('/get-ciudades',[HomeControllerFront::class, 'get_ciudades'])->name('get-ciudades');
Route::post('/newsletter',[HomeControllerFront::class, 'newsletter'])->name('newsletter-front');
Route::post('/dudas',[HomeControllerFront::class, 'dudas'])->name('dudas');
Route::post('/load-more',[HomeControllerFront::class, 'load_more']);
Route::post('/procesa',[HomeControllerFront::class, 'procesa']);

Route::post('/procesa-paypal',[HomeControllerFront::class, 'procesa_paypal']);

/* Views */
Route::view('/quienes-somos','front/quienes-somos')->name('quienes');
Route::view('/politicas','front/politicas')->name('politicas');
Route::view('/fqa','front/FQA')->name('FQA');
Route::view('/dudas-comentarios','front/dudas-comentarios')->name('dudas-comentarios');
Route::view('/contacto','front/contacto')->name('contacto');

// Auth
Route::view('/registrarse','front/registrarse')->name('registrarse');
Route::post('/registro-normal',[HomeControllerFront::class, 'registro_normal'])->name('registro-normal');
Route::post('/registrar-contacto',[HomeControllerFront::class, 'registrar_contacto'])->name('registrar-contacto');
Route::get('/logout',[HomeControllerFront::class, 'logout'])->name('milogout');

// Test
Route::view('/ejemplog','front/ejemplo_graficos')->name('ejemplog');

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth','checkrol']], function(){
    Route::get('/', [HomeControllerAdmin::class,'index'])->name('dashboard');
    Route::resource('/productos', ProductosController::class);
    Route::get('/categorias',[ProductosController::class, 'categorias'])->name('categorias');
    Route::get('/newsletter',[ProductosController::class, 'newsletter'])->name('newsletter');
    Route::get('/newsletter_newv',[ProductosController::class, 'newsletter_newv'])->name('newsletter_newv');
    Route::post('/newsletter_new',[ProductosController::class, 'newsletter_new'])->name('newsletter_new');
    Route::get('/newsletter_list',[ProductosController::class, 'newsletter_list'])->name('newsletter_list');
    Route::post('/nl_correo_destroy',[ProductosController::class, 'nl_correo_destroy'])->name('nl_correo_destroy');
    Route::get('/lista_dudas',[ProductosController::class, 'lista_dudas'])->name('lista_dudas');
    Route::post('/dudas_destroy',[ProductosController::class, 'dudas_destroy'])->name('dudas_destroy');
    Route::post('/respuesta_duda',[ProductosController::class, 'respuesta_duda'])->name('respuesta_duda');
    Route::get('/lista_contacto',[ProductosController::class, 'lista_contacto'])->name('lista_contacto');
    Route::post('/nueva_categoria',[ProductosController::class, 'nueva_categoria'])->name('nueva_categoria');
    Route::post('/editar_categoria',[ProductosController::class, 'editar_categoria'])->name('editar_categoria');
    Route::post('/destroy_categoria',[ProductosController::class, 'destroy_categoria'])->name('destroy_categoria');
    Route::resource('/usuario', UserController::class);
    Route::post('/update_usuario',[UserController::class, 'update_usuario'])->name('update_usuario');
    Route::resource('/pedidos', VentasProductosController::class);
    Route::post('/cambiarEstadoEntrega',[VentasProductosController::class, 'cambiarEstadoEntrega'])->name('cambiarEstadoEntrega');

    //Blog.
    Route::resource('/blogs', BlogController::class);
    Route::post('/blogs/upload',[BlogController::class, 'upload'])->name('upload_cke');
});

Auth::routes();

Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
});