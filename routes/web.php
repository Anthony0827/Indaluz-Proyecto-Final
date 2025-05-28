<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Agricultor\AgricultorController;

// Página principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    // Elección de rol
    Route::get('register', [RegisterController::class, 'choice'])
         ->name('register');

    // Formulario específico según rol
    Route::get('register/{rol}', [RegisterController::class, 'showForm'])
         ->where('rol', 'cliente|agricultor')
         ->name('register.role');

    // Procesar registro, con rol en la URL
    Route::post('register/{rol}', [RegisterController::class, 'register'])
         ->where('rol', 'cliente|agricultor')
         ->name('register.submit');

    // Login
    Route::get('login',  [LoginController::class, 'showLoginForm'])
         ->name('login');
    Route::post('login', [LoginController::class, 'login'])
         ->name('login.submit');
});

// Logout (requiere autenticación)
Route::post('logout', [LoginController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

// Verificación de correo
Route::get('email/verify/{token}', [VerificationController::class, 'verify'])
     ->name('verification.verify');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Cliente
    Route::middleware(['role:cliente'])->group(function () {
        Route::get('cliente/home', function () {
            return view('cliente.home');
        })->name('cliente.home');
    });

    // Dashboard Agricultor
    Route::middleware(['role:agricultor'])->prefix('agricultor')->name('agricultor.')->group(function () {
        Route::get('/dashboard', [AgricultorController::class, 'dashboard'])->name('dashboard');
        
        // Gestión de productos
        Route::resource('productos', \App\Http\Controllers\Agricultor\ProductosController::class);
        Route::post('productos/{id}/reactivate', [\App\Http\Controllers\Agricultor\ProductosController::class, 'reactivate'])->name('productos.reactivate');
        Route::patch('productos/{id}/stock', [\App\Http\Controllers\Agricultor\ProductosController::class, 'updateStock'])->name('productos.updateStock');
        
        // Placeholders para futuras rutas
        Route::get('/pedidos', function () {
            return 'Gestión de pedidos - Por implementar';
        })->name('pedidos.index');
        
        Route::get('/ventas', function () {
            return 'Estadísticas de ventas - Por implementar';
        })->name('ventas.index');
        
        Route::get('/resenas', function () {
            return 'Reseñas de clientes - Por implementar';
        })->name('resenas.index');
        
        // Gestión del perfil
        Route::prefix('perfil')->name('perfil.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agricultor\PerfilController::class, 'index'])->name('index');
            Route::patch('/public', [\App\Http\Controllers\Agricultor\PerfilController::class, 'updatePublic'])->name('updatePublic');
            Route::patch('/private', [\App\Http\Controllers\Agricultor\PerfilController::class, 'updatePrivate'])->name('updatePrivate');
            Route::patch('/password', [\App\Http\Controllers\Agricultor\PerfilController::class, 'updatePassword'])->name('updatePassword');
            Route::get('/preview', [\App\Http\Controllers\Agricultor\PerfilController::class, 'preview'])->name('preview');
        });
    });

    // Dashboard Administrador
    Route::middleware(['role:administrador'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Admin - Por implementar';
        })->name('dashboard');
    });
});