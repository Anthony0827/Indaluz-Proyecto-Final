<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Mostrar elección de rol
    public function choice()
    {
        return view('auth.register-choice');
    }

    // Mostrar formulario específico por rol
    public function showForm($rol)
    {
        if ($rol === 'cliente') {
            return view('auth.register-cliente');       // ← aquí
        }

        if ($rol === 'agricultor') {
            return view('auth.register-agricultor');    // ← y aquí
        }

        abort(404);
    }

    // Procesar registro (igual que antes)
    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'correo'    => 'required|email|unique:usuarios,correo',
            'password'  => 'required|string|min:8|confirmed',
            'rol'       => 'required|in:cliente,agricultor',
            'direccion' => 'nullable|string|max:255',
            'telefono'  => 'nullable|string|max:20',
        ]);

        $user = Usuario::create([
            'nombre'      => $data['nombre'],
            'apellido'    => $data['apellido'],
            'correo'      => $data['correo'],
            'contraseña'  => Hash::make($data['password']),
            'rol'         => $data['rol'],
            'direccion'   => $data['direccion'],
            'telefono'    => $data['telefono'],
        ]);

        event(new Registered($user));
        Auth::login($user);

        return $user->rol === 'agricultor'
            ? redirect()->route('agricultor.dashboard')
            : redirect()->route('tienda.index');
    }
}
