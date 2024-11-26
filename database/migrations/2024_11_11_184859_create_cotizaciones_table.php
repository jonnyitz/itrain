<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id(); // ID de la cotización
            $table->unsignedBigInteger('contacto_id'); // Relación con contacto
            $table->unsignedBigInteger('lote_id'); // Relación con lote
            $table->unsignedBigInteger('cotizador_id'); // Relación con cotizador
            $table->unsignedBigInteger('tipo_id'); // Relación con tipo

            $table->timestamps(); // Timestamps (created_at, updated_at)

            // Claves foráneas para las relaciones
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
            $table->foreign('cotizador_id')->references('id')->on('cotizadores')->onDelete('cascade');
            $table->foreign('tipo_id')->references('id')->on('tipos')->onDelete('cascade');
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
}
