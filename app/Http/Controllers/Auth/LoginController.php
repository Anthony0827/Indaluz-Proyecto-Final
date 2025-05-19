<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        // Validate the login data
        $credentials = $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ], [
            'correo.required'   => 'El correo es obligatorio.',
            'correo.email'      => 'Debes introducir un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Attempt to log the user in
        if (Auth::attempt([
            'correo'   => $credentials['correo'],
            'password' => $credentials['password'],
        ], $request->filled('remember'))) {
            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            // Redirect based on role
            $user = Auth::user();
            switch ($user->rol) {
                case 'agricultor':
                    return redirect()->route('agricultor.dashboard');
                case 'administrador':
                    return redirect()->route('admin.dashboard');
                default:
                    // cliente
                    return redirect()->route('cliente.home');
            }
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'correo' => ['Las credenciales no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate and regenerate session token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
