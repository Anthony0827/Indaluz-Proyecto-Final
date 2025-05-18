<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // 1) Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2) Procesar el intento de login
    public function login(Request $request)
    {
        // Validar campos
        $credentials = $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar usando 'correo' + 'password'
        if (Auth::attempt([
            'correo'   => $credentials['correo'],
            'password' => $credentials['password'],
        ], $request->filled('remember'))) {
            // Regenera la sesión para evitar fijación de sesión
            $request->session()->regenerate();

            // Redirigir según el rol
            $user = Auth::user();
            if ($user->rol === 'agricultor') {
                return redirect()->route('agricultor.dashboard');
            }
            if ($user->rol === 'administrador') {
                return redirect()->route('admin.dashboard');
            }
            // Por defecto, cliente
            return redirect()->route('tienda.index');
        }

        // Falló la autenticación
        throw ValidationException::withMessages([
            'correo' => ['Las credenciales no coinciden con nuestros registros.'],
        ]);
    }

    // 3) Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
