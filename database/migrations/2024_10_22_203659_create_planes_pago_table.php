<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planes_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->decimal('enganche', 10, 2);
            $table->string('modalidad_enganche');
            $table->integer('cantidad_pagos');
            $table->date('fecha_inicio');
            $table->timestamps();
            
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes_pago');
    }
};
