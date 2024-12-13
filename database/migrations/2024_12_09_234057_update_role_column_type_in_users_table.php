<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleColumnTypeInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar el tipo de la columna 'role' de ENUM a STRING
            $table->string('role')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir el cambio si es necesario, volviendo a ENUM
            $table->enum('role', ['administrador', 'trabajador'])->default('trabajador')->change();
        });
    }
}
