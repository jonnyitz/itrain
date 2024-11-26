<?php

// database/migrations/xxxx_xx_xx_xxxxxx_update_pagos_table_add_default_to_banco_caja_interna.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePagosTableAddDefaultToBancoCajaInterna extends Migration
{
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('banco_caja_interna')->default('valor_por_defecto')->change();
        });
    }

    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('banco_caja_interna')->change();
        });
    }
}
