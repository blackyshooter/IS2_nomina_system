<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llama a los seeders aquí
        $this->call(AdminSeeder::class);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            EmpleadoSeeder::class,
        ]);
    }
}
