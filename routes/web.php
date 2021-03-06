<?php

use Illuminate\Support\Facades\Route;
/* Class Front */
use App\Http\Controllers\front\HomeController as HomeControllerFront;
use App\Http\Controllers\front\BlogController as BlogControllerFront;
use App\Http\Controllers\front\CkeckoutController;

/* Class Admin */
use App\Http\Controllers\admin\ProductosController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VentasProductosController;
use App\Http\Controllers\admin\BlogController as BlogControllerAdmin;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\HomeController as HomeControllerAdmin;
use App\Http\Controllers\admin\ReportesController;
use App\Http\Controllers\cliente\ClienteController;
use Illuminate\Support\Facades\Auth;

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

// Checkout
Route::get('/checkout',[CkeckoutController::class, 'checkout'])->name('checkout');
Route::post('/payWithConekta',[CkeckoutController::class, 'payWithConekta'])->name('payWithConekta');
Route::post('/payWithPaypal',[CkeckoutController::class, 'payWithPaypal'])->name('payWithPaypal');
Route::get('/payWithMercadoPago',[CkeckoutController::class, 'payWithMercadoPago'])->name('payWithMercadoPago');
Route::post('/payWithOxxoPay',[CkeckoutController::class, 'payWithOxxoPay'])->name('payWithOxxoPay');
Route::post('/webhookOxxoPay',[CkeckoutController::class, 'webhookOxxoPay'])->name('webhookOxxoPay');

Route::get('/reference-oxxopay', function() {
    return view('mails.reference-oxxopay');
});

// Cupon discount
Route::post('/applyCoupon', [CkeckoutController::class, 'applyCoupon'])->name('applyCoupon');

Route::post('/datos-envio',[HomeControllerFront::class, 'datos_envio'])->name('datos-envio');
/* Blog */
Route::get('/blog', [BlogControllerFront::class, 'index'])->name('blog');
Route::get('/blog/{id}',[BlogControllerFront::class, 'show'])->name('blog.show');

Route::post('/get-ciudades',[HomeControllerFront::class, 'get_ciudades'])->name('get-ciudades');
Route::post('/newsletter',[HomeControllerFront::class, 'newsletter'])->name('newsletter-front');
Route::post('/dudas',[HomeControllerFront::class, 'dudas'])->name('dudas');
Route::post('/load-more',[HomeControllerFront::class, 'load_more']);
Route::post('/procesa',[HomeControllerFront::class, 'procesa']);

/* Views */
Route::view('/quienes-somos','front/quienes-somos')->name('quienes');
Route::view('/politicas','front/politicas')->name('politicas');
Route::view('/fqa','front/FQA')->name('FQA');
Route::view('/dudas-comentarios','front/dudas-comentarios')->name('dudas-comentarios');
Route::view('/contacto','front/contacto')->name('contacto');
Route::view('/distribuidor', 'front/distribuidor')->name('distribuidor');

// Auth
Route::view('/registrarse','front/registrarse')->name('registrarse');
Route::post('/registro-normal',[HomeControllerFront::class, 'registro_normal'])->name('registro-normal');
Route::post('/registrar-contacto',[HomeControllerFront::class, 'registrar_contacto'])->name('registrar-contacto');
Route::get('/logout',[HomeControllerFront::class, 'logout'])->name('milogout');

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
    //Pedidos
    Route::resource('/pedidos', VentasProductosController::class);
    Route::post('/pedidos/get-direccion-customer', [VentasProductosController::class, 'getDireccionCustomer']);
    Route::post('/pedidos/saveOrderManually', [VentasProductosController::class, 'saveOrderManually']);
    Route::post('/pedidos/saveUserManually', [VentasProductosController::class, 'saveUserManually']);

    Route::post('/cambiarEstadoEntrega',[VentasProductosController::class, 'cambiarEstadoEntrega'])->name('cambiarEstadoEntrega');

    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/informe-ventas', [ReportesController::class, 'informe_ventas'])->name('informe-ventas');

    Route::post('/ventas/by_anio', [ReportesController::class, 'ventas_by_anio']);
    Route::get('/ventas/mas_vendidos', [ReportesController::class, 'mas_vendidos']);

    //Blog.
    Route::resource('/blogs', BlogControllerAdmin::class);
    Route::post('/blogs/upload',[BlogControllerAdmin::class, 'upload'])->name('upload_cke');

    // Discounts
    Route::get('/descuentos', [DiscountController::class, 'index'])->name('discounts.index');
    Route::get('/descuentos/crear-cupon', [DiscountController::class, 'createCoupon'])->name('coupons.create');
    Route::post('/descuentos/crear-cupon', [DiscountController::class, 'storeCoupon'])->name('coupons.store');
    Route::delete('/descuentos/eliminar-cupon/{id}', [DiscountController::class, 'destroyCoupon'])->name('coupons.destroy');
    Route::get('/descuentos/editar-cupon/{coupon}', [DiscountController::class, 'edit'])->name('coupons.edit');
    Route::put('/descuentos/editar-cupon/{coupon}', [DiscountController::class, 'update'])->name('coupons.update');

    Route::put('/descuentos/editar-rule/{rule}', [DiscountController::class, 'updateRuleEnvio'])->name('rule.update');
});

Route::group(['middleware'=>['auth']], function(){
    Route::get('/historial_pedidos', [ClienteController::class,'index'])->name('historial_pedidos.index');
    Route::post('/save_historial_pedidos',[ClienteController::class, 'store'])->name('historial_pedidos.store');
    Route::post('/update_historial_pedidos/{id}',[ClienteController::class, 'update'])->name('historial_pedidos.update');
    Route::get('/destroy_historial_pedidos/{id}',[ClienteController::class, 'destroy'])->name('historial_pedidos.destroy');
});

Auth::routes();
