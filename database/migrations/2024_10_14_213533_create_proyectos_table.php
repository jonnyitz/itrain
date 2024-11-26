<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ubicacion'); // Agregar la columna 'ubicacion'
            $table->decimal('total_lotes', 10, 2);
            $table->integer('lotes_disponibles');
            $table->string('estado');
            $table->string('imagen')->nullable(); // Agregar la columna 'imagen' y permitir nulos
            $table->string('moneda')->default('PESOS MEXICANOS ($)');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
