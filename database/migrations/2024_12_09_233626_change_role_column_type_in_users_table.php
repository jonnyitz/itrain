<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRoleColumnTypeInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar el tipo de columna de ENUM a STRING (VARCHAR)
            $table->string('role')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Si se necesita revertir el cambio, podemos restaurar el tipo original a ENUM
            $table->enum('role', ['administrador', 'trabajador'])->default('trabajador')->change();
        });
    }
};
