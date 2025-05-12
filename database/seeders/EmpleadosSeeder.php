<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Empleado::create([
            'nombre' => 'Juan',
            'apellido' => 'Administrador',
            'ci' => '1234567',
            'fecha_nacimiento' => '1990-01-01',
            'direccion' => 'Calle Falsa 123',
            'telefono' => '0981123456',
            'email' => 'admin@sistemanomina.com',
            // otros campos obligatorios de tu tabla empleados
        ]);

    }
}
