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
    Schema::create('ventas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('contacto_id')->constrained('contactos')->onDelete('cascade'); // Relación con la tabla contactos
        $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade'); // Relación con la tabla lotes
        $table->date('fecha_venta');
        $table->string('tipo_venta');
        $table->string('asesor');
        $table->string('numero_contrato');
        $table->string('aval')->nullable();
        $table->decimal('precio_venta_final', 10, 2);
        $table->string('descripcion')->nullable();
        $table->string('observacion')->nullable();
        $table->string('banco_caja_interna');  // Campo independiente
        $table->string('comprobante');
        $table->string('numero_comprobante');
        $table->string('forma_pago');
        $table->decimal('monto_primer_pago', 10, 2);
        $table->dateTime('fecha_hora_pago');
        $table->string('codigo_operacion');
        $table->string('modalidad_enganche');
        $table->decimal('enganche', 10, 2);
        $table->integer('cantidad_pagos');
        $table->date('fecha_inicio');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
