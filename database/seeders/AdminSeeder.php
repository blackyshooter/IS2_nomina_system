<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@sistemanomina.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@sistemanomina.com',
                'password' => Hash::make('ADMIN'),
                'rol' => 'admin',
            ]
        );
    }
}
