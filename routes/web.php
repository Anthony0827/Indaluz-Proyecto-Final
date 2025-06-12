<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Agricultor\AgricultorController;
use App\Http\Controllers\Cliente\PedidoController;
use App\Http\Controllers\Cliente\ResenaController;
use App\Http\Controllers\Agricultor\ResenasController;




// Página pública
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación (usuarios no logueados)
Route::middleware('guest')->group(function () {
    // Elección de rol al registrar
    Route::get('register', [RegisterController::class, 'choice'])
         ->name('register');

    // Formulario de registro según rol (cliente o agricultor)
    Route::get('register/{rol}', [RegisterController::class, 'showForm'])
         ->where('rol', 'cliente|agricultor')
         ->name('register.role');

    // Procesar registro según rol
    Route::post('register/{rol}', [RegisterController::class, 'register'])
         ->where('rol', 'cliente|agricultor')
         ->name('register.submit');

    // Login
    Route::get('login',  [LoginController::class, 'showLoginForm'])
         ->name('login');
    Route::post('login', [LoginController::class, 'login'])
         ->name('login.submit');
});

// Logout (requiere estar autenticado)
Route::post('logout', [LoginController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

// Verificación de correo
Route::get('email/verify/{token}', [VerificationController::class, 'verify'])
     ->name('verification.verify');


// --- Rutas protegidas por autenticación ---
Route::middleware(['auth'])->group(function () {

    // ========= Dashboard Cliente =========
Route::middleware(['role:cliente'])
     ->prefix('cliente')
     ->name('cliente.')
     ->group(function () {
         
         // Alias "catalogo" que carga el home de cliente
         Route::get('/catalogo', [\App\Http\Controllers\Cliente\ClienteController::class, 'home'])
              ->name('catalogo');
         
         // Ruta original "/cliente/home" (si se recibe algún enlace antiguo)
         Route::get('/home', [\App\Http\Controllers\Cliente\ClienteController::class, 'home'])
              ->name('home');

         // Detalle de producto
         Route::get('/producto/{id}', [\App\Http\Controllers\Cliente\ClienteController::class, 'producto'])
              ->name('producto');
         
         // Perfil público de agricultor
         Route::get('/agricultor/{id}', [\App\Http\Controllers\Cliente\ClienteController::class, 'agricultor'])
              ->name('agricultor');

         // Carrito de compras
         Route::get('/carrito', [\App\Http\Controllers\Cliente\CarritoController::class, 'index'])
              ->name('carrito');
         Route::post('/carrito/validar', [\App\Http\Controllers\Cliente\CarritoController::class, 'validar'])
              ->name('carrito.validar');

         // Gestión del perfil del cliente - Ruta principal
         Route::get('/perfil', [\App\Http\Controllers\Cliente\PerfilController::class, 'index'])
              ->name('perfil');
         
         // Rutas adicionales del perfil
         Route::patch('/perfil/update', [\App\Http\Controllers\Cliente\PerfilController::class, 'update'])
              ->name('perfil.update');
         Route::patch('/perfil/avatar', [\App\Http\Controllers\Cliente\PerfilController::class, 'updateAvatar'])
              ->name('perfil.updateAvatar');
         Route::patch('/perfil/password', [\App\Http\Controllers\Cliente\PerfilController::class, 'updatePassword'])
              ->name('perfil.updatePassword');

         // Placeholders para futuras rutas
         Route::get('/checkout', function () {
             return 'Checkout - Por implementar';
         })->name('checkout');

         Route::get('/pedidos', [PedidoController::class, 'index'])
             ->name('pedidos');

             // Guardar reseña
         Route::post('/pedidos/{id}/reseña', [ResenaController::class, 'store'])
              ->name('pedidos.reseña.store');

         // Editar reseña
         Route::put('/pedidos/{id}/reseña', [ResenaController::class, 'update'])
              ->name('pedidos.reseña.update');
       // Detalle de pedido
        Route::get('/pedidos/{id}', [PedidoController::class, 'show'])
             ->name('pedidos.show');

         Route::get('/direcciones', function () {
             return 'Mis direcciones - Por implementar';
         })->name('direcciones');


          // Gestión del perfil del cliente - Ruta principal
          Route::get('/perfil', [\App\Http\Controllers\Cliente\PerfilController::class, 'index'])
               ->name('perfil');

          // Rutas adicionales del perfil
          Route::patch('/perfil/update', [\App\Http\Controllers\Cliente\PerfilController::class, 'update'])
               ->name('perfil.update');
          Route::patch('/perfil/avatar', [\App\Http\Controllers\Cliente\PerfilController::class, 'updateAvatar'])
               ->name('perfil.updateAvatar');
          Route::patch('/perfil/password', [\App\Http\Controllers\Cliente\PerfilController::class, 'updatePassword'])
               ->name('perfil.updatePassword');

          // Proceso de checkout
          Route::get('/checkout', [\App\Http\Controllers\Cliente\CheckoutController::class, 'index'])
               ->name('checkout');
          Route::post('/checkout/procesar', [\App\Http\Controllers\Cliente\CheckoutController::class, 'procesar'])
               ->name('checkout.procesar');
          Route::get('/pedido/{id}/confirmacion', [\App\Http\Controllers\Cliente\CheckoutController::class, 'confirmacion'])
               ->name('pedido.confirmacion');

          // Actualizar carrito para usar sesiones
          Route::post('/carrito/agregar', [\App\Http\Controllers\Cliente\CarritoController::class, 'agregar'])
               ->name('carrito.agregar');
          Route::post('/carrito/actualizar', [\App\Http\Controllers\Cliente\CarritoController::class, 'actualizar'])
               ->name('carrito.actualizar');
          Route::post('/carrito/eliminar', [\App\Http\Controllers\Cliente\CarritoController::class, 'eliminar'])
               ->name('carrito.eliminar');
     });


    // ======== Dashboard Agricultor ========
    Route::middleware(['role:agricultor'])
         ->prefix('agricultor')
         ->name('agricultor.')
         ->group(function () {
             
             // Dashboard principal de agricultor
             Route::get('/dashboard', [AgricultorController::class, 'dashboard'])
                  ->name('dashboard');

             // Gestión de productos (CRUD + reactivar + actualizar stock)
             Route::resource('productos', \App\Http\Controllers\Agricultor\ProductosController::class);
             Route::post('productos/{id}/reactivate', [\App\Http\Controllers\Agricultor\ProductosController::class, 'reactivate'])
                  ->name('productos.reactivate');
             Route::patch('productos/{id}/stock', [\App\Http\Controllers\Agricultor\ProductosController::class, 'updateStock'])
                  ->name('productos.updateStock');

             // Secciones pendientes de implementar
             Route::get('/pedidos', function () {
                 return 'Gestión de pedidos - Por implementar';
             })->name('pedidos.index');

             Route::prefix('ventas')->name('ventas.')->group(function () {
               Route::get('/', [\App\Http\Controllers\Agricultor\VentasController::class, 'index'])
                    ->name('index');
               Route::get('/exportar', [\App\Http\Controllers\Agricultor\VentasController::class, 'exportar'])
                    ->name('exportar');
               });

             Route::get('/resenas', [ResenasController::class, 'index'])
              ->name('resenas.index');



             // Gestión del perfil del agricultor (público, privado, contraseña, preview)
             Route::prefix('perfil')->name('perfil.')->group(function () {
                 Route::get('/', [\App\Http\Controllers\Agricultor\PerfilController::class, 'index'])
                      ->name('index');
                 Route::patch('/public', [\App\Http\Controllers\Agricultor\PerfilController::class, 'updatePublic'])
                      ->name('updatePublic');
                 Route::patch('/private', [\App\Http\Controllers\Agricultor\PerfilController::class, 'updatePrivate'])
                      ->name('updatePrivate');
                 Route::patch('/password', [\App\Http\Controllers\Agricultor\PerfilController::class, 'updatePassword'])
                      ->name('updatePassword');
                 Route::get('/preview', [\App\Http\Controllers\Agricultor\PerfilController::class, 'preview'])
                      ->name('preview');
             });
         });


    // ======== Dashboard Administrador ========
    Route::middleware(['role:administrador'])
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {
             Route::get('/dashboard', function () {
                 return 'Dashboard Admin - Por implementar';
             })->name('dashboard');
         });
});
