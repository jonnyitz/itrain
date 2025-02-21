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
            $table->unsignedBigInteger('banco_id')->nullable(); // Campo banco_id
    
            // Agregar la clave foránea
            $table->foreign('banco_id')->references('id')->on('bancos')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['banco_id']);
            $table->dropColumn('banco_id');
        });
    }
};
