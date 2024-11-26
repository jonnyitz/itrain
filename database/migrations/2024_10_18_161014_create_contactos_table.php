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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('curp_rfc');
            $table->string('telefono');
            $table->string('direccion');
            $table->text('observacion')->nullable();
            $table->timestamp('deleted_at')->nullable(); // Agregamos el campo deleted_at
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('contactos');
    }
    
};
