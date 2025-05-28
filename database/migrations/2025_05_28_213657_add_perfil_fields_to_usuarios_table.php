<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerfilFieldsToUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Campos del perfil público
            $table->string('nombre_empresa', 100)->nullable()->after('telefono');
            $table->text('descripcion_publica')->nullable()->after('nombre_empresa');
            $table->integer('anos_experiencia')->nullable()->after('descripcion_publica');
            $table->text('certificaciones')->nullable()->after('anos_experiencia');
            $table->text('metodos_cultivo')->nullable()->after('certificaciones');
            $table->string('horario_atencion', 200)->nullable()->after('metodos_cultivo');
            $table->string('foto_perfil')->nullable()->after('horario_atencion');
            $table->string('foto_portada')->nullable()->after('foto_perfil');
            
            // Campos privados adicionales
            $table->string('codigo_postal', 5)->nullable()->after('direccion');
            $table->string('municipio', 100)->nullable()->after('codigo_postal');
            $table->string('provincia', 100)->nullable()->after('municipio');
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_empresa',
                'descripcion_publica',
                'anos_experiencia',
                'certificaciones',
                'metodos_cultivo',
                'horario_atencion',
                'foto_perfil',
                'foto_portada',
                'codigo_postal',
                'municipio',
                'provincia'
            ]);
        });
    }
}