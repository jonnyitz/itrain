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
            // Especificamos el nombre correcto de la tabla a la que hace referencia la clave foránea
            $table->foreignId('cotizador_id')->constrained('cotizadores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropForeign(['cotizador_id']);
            $table->dropColumn('cotizador_id');
        });
    }
};
