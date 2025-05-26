<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja la petición entrantse.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar que el usuario tenga el rol correcto
        if (Auth::user()->rol !== $role) {
            // Redirigir según el rol del usuario
            switch (Auth::user()->rol) {
                case 'administrador':
                    return redirect()->route('admin.dashboard');
                case 'agricultor':
                    return redirect()->route('agricultor.dashboard');
                case 'cliente':
                    return redirect()->route('cliente.home');
                default:
                    // Si no tiene rol válido, cerrar sesión
                    Auth::logout();
                    return redirect()->route('login')
                        ->with('error', 'No tienes permisos para acceder a esta sección.');
            }
        }

        return $next($request);
    }
}