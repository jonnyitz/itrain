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
    Schema::table('gastos_generales', function (Blueprint $table) {
        $table->unsignedBigInteger('proyecto_id')->after('id'); // Agrega la columna después del id
        $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade'); // Relación con la tabla proyectos
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('gastos_generales', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']);
            $table->dropColumn('proyecto_id');
        });
    }
    
};
