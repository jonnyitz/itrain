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
        Schema::table('ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('contacto_id')->nullable();
    
            // Opcional: Añadir clave foránea
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['contacto_id']);
            $table->dropColumn('contacto_id');
        });
    }
    
};
