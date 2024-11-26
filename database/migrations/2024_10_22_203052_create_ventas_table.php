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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('contacto');
            $table->foreignId('contacto_id')->constrained()->onDelete('cascade'); // Mantén este campo
            $table->date('fecha_venta');
            $table->string('tipo_venta');
            $table->string('asesor');
            $table->string('numero_contrato');
            $table->string('aval')->nullable();
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
