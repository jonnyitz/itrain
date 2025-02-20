<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEstadoColumnInLotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lotes', function (Blueprint $table) {
            // Modificar la columna 'estado' para incluir los nuevos valores
            $table->enum('estado', ['activo', 'inactivo', 'cancelado', 'reservado', 'disponible', 'vendido'])->default('activo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            // Revertir la columna 'estado' al estado anterior
            $table->enum('estado', ['activo', 'inactivo', 'cancelado', 'reservado'])->default('activo')->change();
        });
    }
}
