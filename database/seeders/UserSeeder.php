<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = Usuario::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('Administrador');

        $gerente = Usuario::create([
            'name' => 'Gerente',
            'email' => 'gerente@example.com',
            'password' => Hash::make('gerente123'),
        ]);
        $gerente->assignRole('Gerente');

        $asistente = Usuario::create([
            'name' => 'Asistente',
            'email' => 'asistente@example.com',
            'password' => Hash::make('asistente123'),
        ]);
        $asistente->assignRole('Asistente');

        $empleado = Usuario::create([
            'name' => 'Empleado',
            'email' => 'empleado@example.com',
            'password' => Hash::make('empleado123'),
        ]);
        $empleado->assignRole('Empleado');
    }
}
