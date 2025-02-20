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
            $table->integer('meses')->nullable()->change();
            $table->decimal('enganche', 10, 2)->nullable()->change();
            $table->integer('cantidad_pagos')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->integer('meses')->nullable(false)->change();
            $table->decimal('enganche', 10, 2)->nullable(false)->change();
            $table->integer('cantidad_pagos')->nullable(false)->change();
        });
    }
};
