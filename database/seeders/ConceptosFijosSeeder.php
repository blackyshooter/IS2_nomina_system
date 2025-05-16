<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConceptoSalarial;

class ConceptosFijosSeeder extends Seeder
{
    public function run()
    {
        // Crear o actualizar concepto Bonificación por hijos
        ConceptoSalarial::updateOrCreate(
            ['descripcion' => 'Bonificación por hijos'],
            [
                'tipo_concepto' => 'credito',
                'fijo' => true,
                'afecta_ips' => false,
                'afecta_aguinaldo' => false,
            ]
        );

        // Crear o actualizar concepto Descuento IPS
        ConceptoSalarial::updateOrCreate(
            ['descripcion' => 'Descuento IPS'],
            [
                'tipo_concepto' => 'debito',
                'fijo' => true,
                'afecta_ips' => false,
                'afecta_aguinaldo' => false,
            ]
        );
    }
}
