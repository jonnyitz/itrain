<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => '456@ejemplo.com',
            'password' => bcrypt('123456789'),
            'role' => 'administrador',
        ]);

        User::create([
            'name' => 'Administrador',
            'email' => 'fernandezdelreal@hotmail.com',
            'password' => bcrypt('osFederE01$123$5813'),
            'role' => 'administrador',
        ]);

        User::create([
            'name' => 'Administrador',
            'email' => 'hans_zac@outlook.com',
            'password' => bcrypt('Hansell1990'),
            'role' => 'administrador',
        ]);

        // Agregar el nuevo usuario
        User::create([
            'name' => 'Claudia Luna',
            'email' => 'clau_luna.22@hotmail.com',
            'password' => bcrypt('FDRC.124'),  // La contraseña cifrada con Bcrypt
            'role' => 'ventas',
            'activo' => 1,
        ]);
    }
}
