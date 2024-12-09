<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRoleColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Modificar la columna 'role' para establecer un valor predeterminado y evitar que sea NULL
            $table->enum('role', ['gerencia', 'ingenieria', 'administrador', 'ventas', 'admin_ingen'])
                ->default('ventas')  // Establecer 'ventas' como valor predeterminado
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir la columna 'role' a su estado original, sin valor predeterminado
            $table->enum('role', ['gerencia', 'ingenieria', 'administrador', 'ventas', 'admin_ingen'])
                ->nullable()  // Permitir NULL (si es necesario)
                ->change();
        });
    }
}
