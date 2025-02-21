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
        Schema::table('contactos', function (Blueprint $table) {
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->foreign('proyecto_id')->references('id')->on('proyectos'); // Suponiendo que tienes una tabla de proyectos
        });
    }
    
    public function down()
    {
        Schema::table('contactos', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']);
            $table->dropColumn('proyecto_id');
        });
    }
    
};
