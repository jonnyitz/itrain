<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToContactoInVentasTable extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->string('contacto')->default('valor_por_defecto')->change();
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->string('contacto')->default(null)->change();
        });
    }
}
