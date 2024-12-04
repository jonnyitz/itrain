<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendedorToManzanasTable extends Migration
{
    public function up()
    {
        Schema::table('manzanas', function (Blueprint $table) {
            $table->string('vendedor')->nullable()->after('proyecto_id'); // Agregar campo vendedor
        });
    }

    public function down()
    {
        Schema::table('manzanas', function (Blueprint $table) {
            $table->dropColumn('vendedor'); // Eliminar campo vendedor
        });
    }
};
