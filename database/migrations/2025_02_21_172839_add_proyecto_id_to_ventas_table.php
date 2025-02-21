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
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']);
            $table->dropColumn('proyecto_id');
        });
    }
    
};
