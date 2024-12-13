<?php

// database/migrations/2024_12_09_XXXXXX_update_role_enum_in_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleEnumInUsersTable extends Migration
{
    public function up()
    {
        // Aquí eliminamos el valor por defecto, solo permitimos los roles posibles
        DB::statement("ALTER TABLE users CHANGE role role ENUM('gerencia', 'ingenieria', 'administrador', 'ventas', 'admin_ingen')");
    }

    public function down()
    {
        // Si necesitamos revertir, devolvemos a los valores anteriores
        DB::statement("ALTER TABLE users CHANGE role role ENUM('gerencia', 'ingenieria', 'administrador', 'ventas') DEFAULT 'gerencia'");
    }
}

