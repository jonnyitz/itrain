<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSedesTable extends Migration
{
    public function up()
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->string('pais')->after('telefonos');
            $table->string('estado')->after('pais');
            $table->string('municipio')->after('estado');
            $table->string('localidad')->after('municipio');
            $table->string('email')->unique()->after('localidad');
        });
    }

    public function down()
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->dropColumn(['pais', 'estado', 'municipio', 'localidad', 'email']);
        });
    }
}
