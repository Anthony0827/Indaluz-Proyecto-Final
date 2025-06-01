<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Mostrar el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el intento de inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ], [
            'correo.required'   => 'El correo es obligatorio.',
            'correo.email'      => 'Debes introducir un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt([
            'correo'   => $credentials['correo'],
            'password' => $credentials['password'],
        ], $request->filled('remember'))) {

            // Regenerar la sesión para evitar fijación de sesión
            $request->session()->regenerate();

            // Comprobar que el usuario haya verificado su correo
            if (! Auth::user()->verificado) {
                // Cerrar sesión inmediatamente
                Auth::logout();

                // Redirigir de nuevo al login con mensaje de error
                return redirect()
                    ->route('login')
                    ->withErrors(['correo' => 'Debes verificar tu cuenta antes de iniciar sesión.']);
            }

            // Redirigir según el rol del usuario
            switch (Auth::user()->rol) {
                case 'administrador':
                    return redirect()->route('admin.dashboard');
                case 'agricultor':
                    return redirect()->route('agricultor.dashboard');
                default:
                    // cliente
                    return redirect()->route('cliente.home');
            }
        }

        // Si la autenticación falla, lanzar excepción con mensaje en español
        throw ValidationException::withMessages([
            'correo' => ['Las credenciales no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Cerrar la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Cerrar sesión
        Auth::logout();

        // Invalidar e regenerar token de sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al home
        return redirect()->route('home');
    }

    

    /**
     * Este método se ejecuta justo después de que el usuario se autentique correctamente.
     * Se usa para redirigir según rol.
     */
    protected function authenticated(Request $request, $user)
    {
        // Si es cliente, lo mandamos al catálogo/home de cliente
        if ($user->hasRole('cliente')) {
            return redirect()->route('cliente.catalogo');
        }

        // Si es agricultor, al dashboard de agricultor
        if ($user->hasRole('agricultor')) {
            return redirect()->route('agricultor.dashboard');
        }

        // Si es administrador, al dashboard de admin
        if ($user->hasRole('administrador')) {
            return redirect()->route('admin.dashboard');
        }

        // Si no coincide ningún rol, redirigir al home público
        return redirect()->route('home');
    }
}
