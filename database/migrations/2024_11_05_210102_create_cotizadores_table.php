<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizadoresTable extends Migration
{
    public function up()
    {
        Schema::create('cotizadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Campo para el nombre del cotizador
            $table->timestamps();
        });

        Schema::create('tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Campo para el tipo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos');
        Schema::dropIfExists('cotizadores');
    }
}

