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
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contacto_id'); // Relación con contactos
            $table->decimal('monto', 10, 2);
            $table->string('tipo_recibo');
            $table->date('fecha');
            $table->string('correlativo');
            $table->string('metodo_pago');
            $table->string('concepto');
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos');
    }
};
