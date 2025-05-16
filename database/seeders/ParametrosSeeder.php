<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametrosSeeder extends Seeder
{
    public function run()
    {
        DB::table('parametros')->updateOrInsert(
            ['clave' => 'salario_minimo_oficial'],
            ['valor' => '2798309', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}