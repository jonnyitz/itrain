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
            // Agregar la columna 'estado' con un valor predeterminado
            $table->string('estado')->default('activo');  // Puedes cambiar el valor predeterminado según sea necesario
        });
    }
    
    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            // Eliminar la columna 'estado' en caso de que quieras revertir la migración
            $table->dropColumn('estado');
        });
    }
    
};
