<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Detrás del reverse proxy Caddy (HTTPS terminado en el proxy)
        $middleware->trustProxies(at: '*');
        // Bloquea acciones sensibles en el demo (cambio de contraseña)
        $middleware->web(append: [
            \App\Http\Middleware\DemoGuard::class,
        ]);
        // Registrar el middleware de rol aquí
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();