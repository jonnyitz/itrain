<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManzanasTable extends Migration
{
    public function up()
    {
        Schema::create('manzanas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre de la manzana
            $table->unsignedBigInteger('proyecto_id'); // Relación con la tabla proyectos
            $table->timestamps();

            // Clave foránea
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('manzanas');
    }
}

