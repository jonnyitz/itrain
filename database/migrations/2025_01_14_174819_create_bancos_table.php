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
    Schema::create('bancos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_banco');
        $table->string('tipo_cuenta');
        $table->string('moneda');
        $table->string('numero_cuenta');
        $table->string('cci');
        $table->string('nombre_responsable');
        $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade'); // Relación con la tabla de ventas
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos');
    }
};
