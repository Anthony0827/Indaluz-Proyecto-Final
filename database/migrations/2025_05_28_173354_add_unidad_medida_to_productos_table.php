<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnidadMedidaToProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Añadir columna para unidad de medida
            $table->enum('unidad_medida', ['unidad', 'kilogramo', 'gramo', 'manojo', 'docena', 'caja'])
                  ->default('kilogramo')
                  ->after('categoria');
            
            // Cambiar cantidad_inventario a decimal para permitir fracciones (ej: 2.5 kg)
            $table->decimal('cantidad_inventario', 10, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('unidad_medida');
            $table->integer('cantidad_inventario')->change();
        });
    }
}