<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Verificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Verifica el token y activa la cuenta.
     */
    public function verify(string $token)
    {
        $record = Verificacion::where('token', $token)->first();

        if (! $record) {
            return redirect()
                ->route('login')
                ->with('error', 'Token de verificación inválido.');
        }

        if ($record->verificado) {
            return redirect()
                ->route('login')
                ->with('info', 'Tu cuenta ya está verificada.');
        }

        $user = Usuario::find($record->id_usuario);

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('error', 'Usuario no encontrado.');
        }

        // Marca usuario y registro como verificados
        $user->verificado = 1;
        $user->save();

        $record->verificado = 1;
        $record->save();

        return redirect()
            ->route('login')
            ->with('success', '¡Cuenta verificada! Ahora puedes iniciar sesión.');
    }
}
