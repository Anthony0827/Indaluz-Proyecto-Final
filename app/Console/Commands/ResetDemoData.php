<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Restaura los datos demo de Indaluz: recarga las cuentas y el catálogo de
 * prueba y limpia pedidos/reseñas/etc. Así el demo público no se degrada.
 *
 * Se ejecuta automáticamente cada 15 min (ver routes/console.php) y puede
 * lanzarse a mano con:  php artisan demo:reset
 */
class ResetDemoData extends Command
{
    protected $signature = 'demo:reset';
    protected $description = 'Restaura los datos de demostración de Indaluz';

    public function handle(): int
    {
        $sql = database_path('demo_seed.sql');

        if (! is_file($sql)) {
            $this->error("No se encuentra {$sql}");
            return self::FAILURE;
        }

        try {
            DB::unprepared(file_get_contents($sql));
        } catch (\Throwable $e) {
            $this->error('Fallo al restaurar datos demo: '.$e->getMessage());
            return self::FAILURE;
        }

        $this->info('Datos demo restaurados correctamente.');
        return self::SUCCESS;
    }
}
