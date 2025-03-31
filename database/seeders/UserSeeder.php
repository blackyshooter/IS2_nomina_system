<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('Administrador');

        $gerente = User::create([
            'name' => 'Gerente',
            'email' => 'gerente@example.com',
            'password' => Hash::make('gerente123'),
        ]);
        $gerente->assignRole('Gerente');

        $asistente = User::create([
            'name' => 'Asistente',
            'email' => 'asistente@example.com',
            'password' => Hash::make('asistente123'),
        ]);
        $asistente->assignRole('Asistente');

        $empleado = User::create([
            'name' => 'Empleado',
            'email' => 'empleado@example.com',
            'password' => Hash::make('empleado123'),
        ]);
        $empleado->assignRole('Empleado');
    }
}
