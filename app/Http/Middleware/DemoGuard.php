<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Protege el demo público: bloquea acciones sensibles (cambiar la contraseña
 * de las cuentas demo) para que nadie deje fuera a los demás visitantes.
 *
 * Se registra como middleware global del grupo web y actúa solo sobre las
 * rutas listadas en $bloqueadas. El resto de cambios se revierten solos con
 * `demo:reset` cada 15 minutos.
 */
class DemoGuard
{
    /** Nombres de ruta cuyas acciones quedan deshabilitadas en el demo. */
    private array $bloqueadas = [
        'cliente.perfil.updatePassword',
        'agricultor.perfil.updatePassword',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $ruta = $request->route()?->getName();

        if ($ruta !== null && in_array($ruta, $this->bloqueadas, true)) {
            $mensaje = 'Esta acción está deshabilitada en la versión demo. '
                     . 'Los datos se restauran automáticamente cada pocos minutos.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $mensaje], 403);
            }

            return redirect()->back()
                ->with('demo_bloqueado', $mensaje)
                ->with('error', $mensaje);
        }

        return $next($request);
    }
}
