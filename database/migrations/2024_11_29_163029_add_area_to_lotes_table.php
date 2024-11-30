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
        Schema::table('lotes', function (Blueprint $table) {
            $table->float('area')->nullable()->after('precio_m2'); // Agregar columna área
        });
    }
    
    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropColumn('area'); // Eliminar columna si se hace rollback
        });
    }
    
};
