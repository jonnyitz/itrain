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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable(); // Si puede ser nulo
            $table->unsignedBigInteger('grupo_id')->nullable(); // Si puede ser nulo

            // Agregar las claves foráneas
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar las claves foráneas
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['grupo_id']);

            // Eliminar las columnas
            $table->dropColumn('empresa_id');
            $table->dropColumn('grupo_id');
        });
    }
};
