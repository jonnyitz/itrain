<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProyectoIdToConceptosTable extends Migration
{
    public function up()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            // Agregar la columna proyecto_id
            $table->unsignedBigInteger('proyecto_id')->nullable();

            // Establecer la relación con la tabla proyectos (si corresponde)
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            // Eliminar la columna y la clave foránea
            $table->dropForeign(['proyecto_id']);
            $table->dropColumn('proyecto_id');
        });
    }
}
