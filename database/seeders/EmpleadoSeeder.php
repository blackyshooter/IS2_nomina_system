<?php
// database/seeders/EmpleadoSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        Empleado::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
            'email' => 'juan.perez@example.com',
            'telefono' => '123456789',
            'area_id' => 1, // Asegúrate de tener esta área creada
            'cargo' => 'Analista'
        ]);

        Empleado::create([
            'nombre' => 'Laura',
            'apellido' => 'Gómez',
            'dni' => '87654321',
            'email' => 'laura.gomez@example.com',
            'telefono' => '987654321',
            'area_id' => 2,
            'cargo' => 'Desarrollador'
        ]);
    }
}
