<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleColumnDefaultInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar el valor predeterminado de la columna 'role' a 'trabajador'
            $table->string('role')->default('trabajador')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir a la configuración original si es necesario
            $table->string('role')->default('trabajador')->change();
        });
    }
}

