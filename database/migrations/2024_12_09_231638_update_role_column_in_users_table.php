<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleColumnInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar la columna 'role' de tipo ENUM a VARCHAR
            $table->string('role')->change();  // Cambia el tipo de columna a VARCHAR
        });
    }

    public function down()
    {
        // Si necesitamos revertir la migración, volvemos a ENUM
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['gerencia', 'ingenieria', 'administrador', 'ventas', 'admin_ingen'])->default('gerencia')->change();
        });
    }
}
