<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parametro;
use App\Models\ConceptoSalarial;

class ParametrosYConceptosSeeder extends Seeder
{
    public function run()
    {
        // Parámetro: salario mínimo oficial
        Parametro::updateOrCreate(
            ['clave' => 'salario_minimo_oficial'],
            ['valor' => '2500000']  // Por ejemplo 2.500.000 Gs.
        );

        // Conceptos salariales base para pruebas
        ConceptoSalarial::updateOrCreate(
            ['descripcion' => 'Salario Base'],
            [
                'tipo_concepto' => 'credito',
                'fijo' => true,
                'afecta_ips' => true,
                'afecta_aguinaldo' => true,
            ]
        );

        ConceptoSalarial::updateOrCreate(
            ['descripcion' => 'Bonificación por hijo'],
            [
                'tipo_concepto' => 'credito',
                'fijo' => false,
                'afecta_ips' => false,
                'afecta_aguinaldo' => false,
            ]
        );

        ConceptoSalarial::updateOrCreate(
            ['descripcion' => 'Descuento IPS'],
            [
                'tipo_concepto' => 'debito',
                'fijo' => false,
                'afecta_ips' => false,
                'afecta_aguinaldo' => false,
            ]
        );

        // Puedes agregar más conceptos si quieres
    }
}
