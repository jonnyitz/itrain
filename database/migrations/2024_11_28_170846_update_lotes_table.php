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
        Schema::table('lotes', function (Blueprint $table) {
            // Agregar nuevas columnas
            $table->unsignedBigInteger('manzana_id')->nullable()->after('venta_id');
            $table->decimal('costo_aproximado', 10, 2)->nullable()->after('lote');
            $table->decimal('precio_venta_contado', 10, 2)->nullable()->after('costo_aproximado');
            $table->decimal('medida_frontal', 10, 2)->nullable()->after('descripcion');
            $table->decimal('medida_costado_derecho', 10, 2)->nullable();
            $table->decimal('medida_costado_izquierdo', 10, 2)->nullable();
            $table->decimal('medida_posterior', 10, 2)->nullable();
            $table->string('colindancia_frontal')->nullable();
            $table->string('colindancia_derecho')->nullable();
            $table->string('colindancia_izquierdo')->nullable();
            $table->string('colindancia_posterior')->nullable();
            $table->decimal('precio_m2', 10, 2)->nullable()->after('precio_venta_contado');

            // Relación con manzanas
            $table->foreign('manzana_id')->references('id')->on('manzanas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            // Eliminar columnas añadidas
            $table->dropForeign(['manzana_id']);
            $table->dropColumn([
                'manzana_id',
                'costo_aproximado',
                'precio_venta_contado',
                'medida_frontal',
                'medida_costado_derecho',
                'medida_costado_izquierdo',
                'medida_posterior',
                'colindancia_frontal',
                'colindancia_derecho',
                'colindancia_izquierdo',
                'colindancia_posterior',
                'precio_m2',
            ]);
        });
    }
};
