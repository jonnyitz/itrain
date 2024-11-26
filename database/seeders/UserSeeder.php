<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador', // Nombre del usuario
            'email' => '456@ejemplo.com', // Correo electrónico
            'password' => bcrypt('123456789'), // Contraseña encriptada
            'role' => 'administrador', // Asumiendo que tienes un campo 'role'
        ]);
    }
}
