<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ProductosController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VentasProductosController;


use App\Http\Controllers\admin\BlogController;

use App\Http\Controllers\front\HomeController;

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


//Front routes
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::view('/quienes-somos','front/quienes-somos')->name('quienes');


Route::view('/ejemplog','front/ejemplo_graficos')->name('ejemplog');


Route::view('/politicas','front/politicas')->name('politicas');

Route::view('/fqa','front/FQA')->name('FQA');

Route::view('/dudas-comentarios','front/dudas-comentarios')->name('dudas-comentarios');

Route::get('filtrar_puntos',[HomeController::class, 'filtrar_puntos'])->name('filtrar_puntos');

Route::post('getciudades',[HomeController::class, 'getciudades'])->name('getciudades');


Route::post('dudas',[HomeController::class, 'dudas'])->name('dudas');


Route::get('puntos-venta',[HomeController::class, 'puntos_venta'])->name('puntos-venta');

Route::view('/contacto','front/contacto')->name('contacto');

Route::post('newsletter',[HomeController::class, 'newsletter'])->name('newsletter_front');


Route::get('/productos',[HomeController::class, 'productos'])->name('productos');
Route::post('filtrar_productos',[HomeController::class, 'filtrar_productos']);


Route::post('loadmore',[HomeController::class, 'loadmore']);


Route::get('/mis-favoritos',[HomeController::class, 'misfavoritos'])->name('mis-favoritos');


Route::get('/detalle-producto/{producto?}',[HomeController::class, 'detalle_producto'])->name('detalle-producto');

Route::get('/carrito',[HomeController::class, 'carrito'])->name('carrito');

Route::get('/checkout',[HomeController::class, 'checkout'])->name('checkout')->middleware(['checkrol']);


Route::post('/datosenvio',[HomeController::class, 'datosenvio'])->name('datosenvio');

Route::post('/payment',[HomeController::class, 'payment'])->name('payment');



Route::get('/carrito',[HomeController::class, 'carrito'])->name('carrito');


Route::view('registrarse','front/registrarse')->name('registrarse');

Route::post('/registro_normal',[HomeController::class, 'registro_normal'])->name('registro_normal');

Route::post('/registrar_contacto',[HomeController::class, 'registrar_contacto'])->name('registrar_contacto');


Route::get('/logout',[HomeController::class, 'logout'])->name('milogout');



Route::post('procesa',[HomeController::class, 'procesa']);
//Admin routes


Route::group(['prefix' => 'admin', 'middleware' => ['auth','checkrol']], function(){


    Route::get('/', [App\Http\Controllers\HomeController::class,'index'])->name('dashboard');

    Route::resource('productos', ProductosController::class);

    Route::get('/categorias',[ProductosController::class, 'categorias'])->name('categorias');


    Route::get('/newsletter',[ProductosController::class, 'newsletter'])->name('newsletter');
    
    Route::get('/newsletter_newv',[ProductosController::class, 'newsletter_newv'])->name('newsletter_newv');
    Route::post('newsletter_new',[ProductosController::class, 'newsletter_new'])->name('newsletter_new');
    Route::get('newsletter_list',[ProductosController::class, 'newsletter_list'])->name('newsletter_list');
    Route::post('nl_correo_destroy',[ProductosController::class, 'nl_correo_destroy'])->name('nl_correo_destroy');


    Route::get('lista_dudas',[ProductosController::class, 'lista_dudas'])->name('lista_dudas');
    Route::post('dudas_destroy',[ProductosController::class, 'dudas_destroy'])->name('dudas_destroy');
    Route::post('respuesta_duda',[ProductosController::class, 'respuesta_duda'])->name('respuesta_duda');

    Route::get('lista_contacto',[ProductosController::class, 'lista_contacto'])->name('lista_contacto');

    Route::post('nueva_categoria',[ProductosController::class, 'nueva_categoria'])->name('nueva_categoria');
    Route::post('editar_categoria',[ProductosController::class, 'editar_categoria'])->name('editar_categoria');
    Route::post('destroy_categoria',[ProductosController::class, 'destroy_categoria'])->name('destroy_categoria');

    Route::resource('usuario', UserController::class);

    Route::post('update_usuario',[UserController::class, 'update_usuario'])->name('update_usuario');


    Route::resource('pedidos', VentasProductosController::class);


    Route::post('cambiarEstadoEntrega',[VentasProductosController::class, 'cambiarEstadoEntrega'])->name('cambiarEstadoEntrega');

   
    //Blog.
    Route::resource('blogs', BlogController::class);

    Route::post('blogs/upload',[BlogController::class, 'upload'])->name('upload_cke');

});

Auth::routes();

Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
