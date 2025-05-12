<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_usuario' => 'admin01',
            'email' => 'admin@sistemanomina.com',
            'password' => Hash::make('Admin-2025'),
            'nombre_usuario' => 'Administrador',
            'id_empleado' => 1, // asegurate de que este empleado exista    // asegurate de que el rol con id_rol = 1 sea 'Administrador'
        ]);
    }
}
