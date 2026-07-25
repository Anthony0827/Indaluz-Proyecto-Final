<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Red de seguridad del demo: restaura los datos de prueba cada 15 minutos
// por si alguien deja la sesión con cambios. Requiere el scheduler activo
// (supervisor lanza `php artisan schedule:work` en el contenedor).
Schedule::command('demo:reset')
    ->everyFifteenMinutes()
    ->withoutOverlapping();
