<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Puedes comentar la línea anterior si no deseas crear usuarios de prueba
        // User::factory(10)->create();

        // Crea un usuario con los datos especificados
        User::factory()->create([
            'name' => 'Administrador', // Nombre del usuario
            'email' => '456@ejemplo.com', // Correo electrónico
            'password' => bcrypt('123456789'), // Contraseña encriptada
            'role' => 'administrador', // Asumiendo que tienes un campo 'role'
        ]);
         // Llama al seeder PagosTableSeeder para llenar la tabla pagos con los datos proporcionados
         $this->call([
            PagosTableSeeder::class,
        ]);
    }
}
