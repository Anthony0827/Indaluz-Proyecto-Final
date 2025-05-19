<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;


Route::get('/', [HomeController::class, 'index'])->name('home');

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

// Logout
Route::post('logout', [LoginController::class, 'logout'])
     ->name('logout');


// Verificación de correo
Route::get('email/verify/{token}', [VerificationController::class, 'verify'])
     ->name('verification.verify');


// Dashboard Cliente
Route::get('cliente/home', function () {
    return view('cliente.home');
})->middleware('auth')->name('cliente.home');
