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
        Schema::table('ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('manzana_id')->nullable()->after('lote_id'); // Asegúrate de colocarlo en un lugar lógico
            $table->foreign('manzana_id')->references('id')->on('manzanas')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['manzana_id']);
            $table->dropColumn('manzana_id');
        });
    }
    
};
