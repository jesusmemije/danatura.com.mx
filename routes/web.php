<?php

use App\Http\Controllers\admin\BlogController as BlogControllerAdmin;
/* Class Front */
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\HomeController as HomeControllerAdmin;
use App\Http\Controllers\admin\ProductosController;
/* Class Admin */
use App\Http\Controllers\admin\ReportesController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VentasProductosController;
use App\Http\Controllers\cliente\ClienteController;
use App\Http\Controllers\front\BlogController as BlogControllerFront;
use App\Http\Controllers\front\CkeckoutController;
use App\Http\Controllers\front\HomeController as HomeControllerFront;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/lenguaje', [HomeControllerFront::class, 'lenguaje'])->name('lenguaje');
Route::view('/lenguaje', 'auth/plataforma_idioma')->name('lenguaje');

Route::get('/', [HomeControllerFront::class, 'index'])->name('home');
Route::get('/idioma/{idioma?}', [HomeControllerFront::class, 'idioma'])->name('idioma');
Route::get('/_en', [HomeControllerFront::class, 'index_en'])->name('home_en');
Route::get('/duplicar', [HomeControllerFront::class, 'duplicar'])->name('duplicar');

Route::get('/productos', [HomeControllerFront::class, 'productos'])->name('productos');
Route::get('/products', [HomeControllerFront::class, 'productos_en'])->name('productos_en');

Route::get('/galeria', [HomeControllerFront::class, 'galeria'])->name('galeria');
Route::get('/gallery', [HomeControllerFront::class, 'galeria_en'])->name('galeria_en');

Route::get('/venta-zona/{id_zona?}', [HomeControllerFront::class, 'venta_zona'])->name('venta_zona');
Route::post('/venta-zona-productos', [HomeControllerFront::class, 'venta_zona_productos']);

Route::post('/filtrar-productos', [HomeControllerFront::class, 'filtrar_productos']);
Route::post('/filtrar-productos-en', [HomeControllerFront::class, 'filtrar_productos_en']);
Route::get('/puntos-venta', [HomeControllerFront::class, 'puntos_venta'])->name('puntos-venta');
Route::get('/points-of-sale', [HomeControllerFront::class, 'puntos_venta_en'])->name('puntos-venta_en');

Route::get('/filtrar-puntos', [HomeControllerFront::class, 'filtrar_puntos'])->name('filtrar-puntos');

Route::get('/mis-favoritos', [HomeControllerFront::class, 'misfavoritos'])->name('mis-favoritos');
Route::get('/my-favourites', [HomeControllerFront::class, 'misfavoritos_en'])->name('mis-favoritos-en');

Route::get('/detalle-producto/{producto?}', [HomeControllerFront::class, 'detalle_producto'])->name('detalle-producto');
Route::get('/products-detail/{product?}', [HomeControllerFront::class, 'detalle_producto_en'])->name('detalle-producto-en');

Route::get('/carrito', [HomeControllerFront::class, 'carrito'])->name('carrito');
Route::get('/car', [HomeControllerFront::class, 'carrito_en'])->name('carrito_en');

Route::get('/resultados-busqueda', [HomeControllerFront::class, 'resultados_busqueda'])->name('resultados_busqueda');
Route::get('/search-results', [HomeControllerFront::class, 'resultados_busqueda_en'])->name('resultados_busqueda_en');

// Checkout
Route::get('/checkout', [CkeckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout-en', [CkeckoutController::class, 'checkout_en'])->name('checkout_en');

Route::post('/payWithConekta', [CkeckoutController::class, 'payWithConekta'])->name('payWithConekta');
Route::post('/payWithConektaEn', [CkeckoutController::class, 'payWithConektaEn'])->name('payWithConektaEn');

Route::post('/payWithPaypal', [CkeckoutController::class, 'payWithPaypal'])->name('payWithPaypal');
Route::get('/payWithMercadoPago', [CkeckoutController::class, 'payWithMercadoPago'])->name('payWithMercadoPago');
Route::post('/payWithOxxoPay', [CkeckoutController::class, 'payWithOxxoPay'])->name('payWithOxxoPay');
Route::post('/webhookOxxoPay', [CkeckoutController::class, 'webhookOxxoPay'])->name('webhookOxxoPay');

Route::get('/reference-oxxopay', function () {
    return view('mails.reference-oxxopay');
});

// Cupon discount
Route::post('/applyCoupon', [CkeckoutController::class, 'applyCoupon'])->name('applyCoupon');

// Aplicar regla de envío
Route::post('/regla_envio', [CkeckoutController::class, 'regla_envio'])->name('regla_envio');

Route::post('/datos-envio', [HomeControllerFront::class, 'datos_envio'])->name('datos-envio');
Route::post('/datos-envio-en', [HomeControllerFront::class, 'datos_envio_en'])->name('datos-envio_en');
/* Blog */
Route::get('/blog', [BlogControllerFront::class, 'index'])->name('blog');
Route::get('/blog-en', [BlogControllerFront::class, 'index_en'])->name('blog_en');

Route::get('/blog_es/{id?}', [BlogControllerFront::class, 'show'])->name('blog.show');
Route::get('/blog_en/{id?}', [BlogControllerFront::class, 'show_en'])->name('blog_show_en');

Route::post('/get-ciudades', [HomeControllerFront::class, 'get_ciudades'])->name('get-ciudades');
Route::post('/newsletter', [HomeControllerFront::class, 'newsletter'])->name('newsletter-front');
Route::post('/dudas', [HomeControllerFront::class, 'dudas'])->name('dudas');

Route::post('/load-more', [HomeControllerFront::class, 'load_more']);
Route::post('/load-more-en', [HomeControllerFront::class, 'load_more_en']);

Route::post('/procesa', [HomeControllerFront::class, 'procesa']);
// Route::post('/procesa_en',[HomeControllerFront::class, 'procesa_en']);

/* Views */
Route::view('/quienes-somos', 'front/quienes-somos')->name('quienes');
Route::view('/about-us', 'front/en/quienes-somos_en')->name('quienes_en');
Route::view('/politicas', 'front/politicas')->name('politicas');
Route::view('/policies', 'front/en/politicas_en')->name('politicas_en');

Route::view('/fqa', 'front/FQA')->name('FQA');
Route::view('/fqa-en', 'front/en/FQA_en')->name('FQA_en');

Route::view('/dudas-comentarios', 'front/dudas-comentarios')->name('dudas-comentarios');
Route::view('/doubts-comments', 'front/en/dudas-comentarios_en')->name('dudas-comentarios_en');

Route::view('/contacto', 'front/contacto')->name('contacto');
Route::view('/contact', 'front/en/contacto_en')->name('contacto_en');

Route::view('/distribuidor', 'front/distribuidor')->name('distribuidor');
Route::view('/distributor', 'front/en/distribuidor_en')->name('distribuidor_en');

// Auth
Route::view('/registrarse', 'front/registrarse')->name('registrarse');
Route::view('/register-en', 'front/register_en')->name('register_en');
Route::view('/login-en', 'auth/login_en')->name('login_en');

Route::post('/registro-normal', [HomeControllerFront::class, 'registro_normal'])->name('registro-normal');
Route::post('/registrar-contacto', [HomeControllerFront::class, 'registrar_contacto'])->name('registrar-contacto');
Route::post('/registrar-contacto-en', [HomeControllerFront::class, 'registrar_contacto_en'])->name('registrar-contacto_en');
Route::get('/logout/{idioma}', [HomeControllerFront::class, 'logout'])->name('milogout');

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkrol']], function () {
    Route::get('/', [HomeControllerAdmin::class, 'index'])->name('dashboard');
    Route::resource('/productos', ProductosController::class);
    Route::get('/productos-ingles', [ProductosController::class, 'productos_ingles'])->name('productos_ingles');
    Route::get('/categorias', [ProductosController::class, 'categorias'])->name('categorias');
    Route::get('/newsletter', [ProductosController::class, 'newsletter'])->name('newsletter');
    Route::get('/newsletter_newv', [ProductosController::class, 'newsletter_newv'])->name('newsletter_newv');
    Route::post('/newsletter_new', [ProductosController::class, 'newsletter_new'])->name('newsletter_new');
    Route::get('/newsletter_list', [ProductosController::class, 'newsletter_list'])->name('newsletter_list');
    Route::post('/nl_correo_destroy', [ProductosController::class, 'nl_correo_destroy'])->name('nl_correo_destroy');
    Route::get('/lista_dudas', [ProductosController::class, 'lista_dudas'])->name('lista_dudas');
    Route::post('/dudas_destroy', [ProductosController::class, 'dudas_destroy'])->name('dudas_destroy');
    Route::post('/respuesta_duda', [ProductosController::class, 'respuesta_duda'])->name('respuesta_duda');
    Route::get('/lista_contacto', [ProductosController::class, 'lista_contacto'])->name('lista_contacto');
    Route::post('/nueva_categoria', [ProductosController::class, 'nueva_categoria'])->name('nueva_categoria');
    Route::post('/editar_categoria', [ProductosController::class, 'editar_categoria'])->name('editar_categoria');
    Route::post('/destroy_categoria', [ProductosController::class, 'destroy_categoria'])->name('destroy_categoria');
    Route::resource('/usuario', UserController::class);
    Route::post('/update_usuario', [UserController::class, 'update_usuario'])->name('update_usuario');
    // Pedidos
    Route::resource('/pedidos', VentasProductosController::class);
    Route::post('/pedidos/get-direccion-customer', [VentasProductosController::class, 'getDireccionCustomer']);
    Route::post('/pedidos/saveOrderManually', [VentasProductosController::class, 'saveOrderManually']);
    Route::post('/pedidos/saveUserManually', [VentasProductosController::class, 'saveUserManually']);

    Route::post('/cambiarEstadoEntrega', [VentasProductosController::class, 'cambiarEstadoEntrega'])->name('cambiarEstadoEntrega');

    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/informe-ventas', [ReportesController::class, 'informe_ventas'])->name('informe-ventas');

    Route::post('/ventas/by_anio', [ReportesController::class, 'ventas_by_anio']);
    Route::get('/ventas/mas_vendidos', [ReportesController::class, 'mas_vendidos']);

    // Blog.
    Route::resource('/blogs', BlogControllerAdmin::class);
    Route::post('/blogs/upload', [BlogControllerAdmin::class, 'upload'])->name('upload_cke');

    // Discounts
    Route::get('/descuentos', [DiscountController::class, 'index'])->name('discounts.index');
    Route::get('/descuentos/crear-cupon', [DiscountController::class, 'createCoupon'])->name('coupons.create');
    Route::post('/descuentos/crear-cupon', [DiscountController::class, 'storeCoupon'])->name('coupons.store');
    Route::delete('/descuentos/eliminar-cupon/{id}', [DiscountController::class, 'destroyCoupon'])->name('coupons.destroy');
    Route::get('/descuentos/editar-cupon/{coupon}', [DiscountController::class, 'edit'])->name('coupons.edit');
    Route::put('/descuentos/editar-cupon/{coupon}', [DiscountController::class, 'update'])->name('coupons.update');

    Route::put('/descuentos/editar-rule/{rule}', [DiscountController::class, 'updateRuleEnvio'])->name('rule.update');

    Route::get('/venta-zonas', [HomeControllerAdmin::class, 'venta_zonas'])->name('venta_zonas');
    Route::get('/create-zona', [HomeControllerAdmin::class, 'create_zona'])->name('create_zona');
    Route::post('/store-zona', [HomeControllerAdmin::class, 'store_zona'])->name('store_zona');
    Route::get('/edit-zona/{id}', [HomeControllerAdmin::class, 'edit_zona'])->name('edit_zona');
    Route::post('/update-zona', [HomeControllerAdmin::class, 'update_zona'])->name('update_zona');
    Route::post('/zona-destroy/{id}', [HomeControllerAdmin::class, 'zona_destroy'])->name('zona_destroy');

    Route::get('/usuarios-zona/{id_zona}', [HomeControllerAdmin::class, 'usuarios_zona'])->name('usuarios_zona');
    Route::post('/usuarios-zona-store', [HomeControllerAdmin::class, 'usuarios_zona_store'])->name('usuarios_zona_store');
    Route::post('/usuarios-zona-destroy/{id}', [HomeControllerAdmin::class, 'usuarios_zona_destroy'])->name('usuarios_zona_destroy');

    Route::get('/productos-zona/{id_zona}', [HomeControllerAdmin::class, 'productos_zona'])->name('productos_zona');
    Route::post('/productos-zona-store', [HomeControllerAdmin::class, 'productos_zona_store'])->name('productos_zona_store');
    Route::post('/productos-zona-destroy/{id}', [HomeControllerAdmin::class, 'productos_zona_destroy'])->name('productos_zona_destroy');

    // Numeros whatsapp

    Route::get('/numeros-whatsapp', [HomeControllerAdmin::class, 'numeros_whatsapp'])->name('numeros_whatsapp');
    Route::post('/agregar-numeros-whatsapp', [HomeControllerAdmin::class, 'agregar_numeros_whatsapp'])->name('agregar_numeros_whatsapp');
    Route::post('/update-numeros-whatsapp', [HomeControllerAdmin::class, 'update_numeros_whatsapp'])->name('update_numeros_whatsapp');
    Route::post('/destroy-numeros-whatsapp/{id}', [HomeControllerAdmin::class, 'destroy_numeros_whatsapp'])->name('destroy_numeros_whatsapp');

});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/historial_pedidos', [ClienteController::class, 'index'])->name('historial_pedidos.index');
    Route::get('/order-history', [ClienteController::class, 'index_en'])->name('historial_pedidos_en');

    Route::post('/save_historial_pedidos', [ClienteController::class, 'store'])->name('historial_pedidos.store');
    Route::post('/update_historial_pedidos/{id}',[ClienteController::class, 'update'])->name('historial_pedidos.update');
    Route::get('/destroy_historial_pedidos/{id}',[ClienteController::class, 'destroy'])->name('historial_pedidos.destroy');
});

Auth::routes();
