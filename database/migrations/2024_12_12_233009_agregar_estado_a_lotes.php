<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('lotes', function (Blueprint $table) {
        // Cambiar la columna 'estado' si ya existe
        $table->enum('estado', ['activo', 'inactivo', 'cancelado', 'reservado'])->default('activo')->change();
    });
}

public function down()
{
    Schema::table('lotes', function (Blueprint $table) {
        // Revertir la columna 'estado' a su tipo anterior, si es necesario
        $table->string('estado')->default('activo')->change();
    });
}

};
