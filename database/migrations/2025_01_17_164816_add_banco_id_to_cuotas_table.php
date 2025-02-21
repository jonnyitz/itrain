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
    Schema::table('cuotas', function (Blueprint $table) {
        $table->unsignedBigInteger('banco_id')->nullable(); // Campo para la relación con banco
        $table->foreign('banco_id')->references('id')->on('bancos')->onDelete('set null'); // Clave foránea
    });
}

public function down()
{
    Schema::table('cuotas', function (Blueprint $table) {
        $table->dropForeign(['banco_id']);
        $table->dropColumn('banco_id');
    });
}


};
