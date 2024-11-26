<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotasTable extends Migration
{
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contacto_id')->constrained()->onDelete('cascade'); // Relación con la tabla contactos
            $table->foreignId('lote_id')->constrained()->onDelete('cascade'); // Relación con la tabla lotes
            $table->string('comprobante')->nullable();
            $table->string('n_cts')->nullable();
            $table->string('tipo')->nullable();
            $table->date('fecha')->nullable();
            $table->string('rd')->nullable();
            $table->string('voucher')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuotas');
    }
}
