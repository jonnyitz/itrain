<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProyectoIdToLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->unsignedBigInteger('proyecto_id')->nullable()->after('id'); // Agregar la columna
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade'); // Relación con la tabla proyectos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']); // Eliminar la relación
            $table->dropColumn('proyecto_id'); // Eliminar la columna
        });
    }
}
