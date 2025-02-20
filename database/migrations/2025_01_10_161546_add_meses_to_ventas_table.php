<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // En la migración recién creada
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->integer('meses')->nullable(); // Columna meses (puede ser null o con valor)
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('meses'); // Eliminar la columna meses si se revierte la migración
        });
    }

};
