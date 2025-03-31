<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Gerente']);
        Role::create(['name' => 'Asistente']);
        Role::create(['name' => 'Empleado']);
    }
}
