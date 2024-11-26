<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contacto_id');  // Relación con la tabla contactos
            $table->unsignedBigInteger('venta_id');     // Relación con la tabla ventas
            $table->date('fecha_firma');
            $table->date('fecha_pago');
            $table->decimal('monto', 10, 2);
            $table->timestamps();

            // Definición de claves foráneas
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
