<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToPedidosTable extends Migration
{
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Método de pago
            $table->enum('metodo_pago', ['tarjeta', 'efectivo'])->default('efectivo')->after('estado');
            
            // Método de entrega
            $table->enum('metodo_entrega', ['recogida', 'domicilio'])->default('recogida')->after('metodo_pago');
            
            // Fecha preferida de entrega/recogida
            $table->date('fecha_entrega')->nullable()->after('metodo_entrega');
            $table->string('hora_entrega', 50)->nullable()->after('fecha_entrega');
            
            // Notas del cliente
            $table->text('notas_cliente')->nullable()->after('hora_entrega');
            
            // Para pagos con tarjeta (simulados)
            $table->string('numero_transaccion', 50)->nullable()->after('notas_cliente');
            $table->enum('estado_pago', ['pendiente', 'pagado', 'fallido'])->default('pendiente')->after('numero_transaccion');
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'metodo_pago',
                'metodo_entrega',
                'fecha_entrega',
                'hora_entrega',
                'notas_cliente',
                'numero_transaccion',
                'estado_pago'
            ]);
        });
    }
}
