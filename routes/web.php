<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Agricultor\AgricultorController;

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

         Route::get('/pedidos', function () {
             return 'Mis pedidos - Por implementar';
         })->name('pedidos');

         Route::get('/direcciones', function () {
             return 'Mis direcciones - Por implementar';
         })->name('direcciones');
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

             Route::get('/ventas', function () {
                 return 'Estadísticas de ventas - Por implementar';
             })->name('ventas.index');

             Route::get('/resenas', function () {
                 return 'Reseñas de clientes - Por implementar';
             })->name('resenas.index');

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
