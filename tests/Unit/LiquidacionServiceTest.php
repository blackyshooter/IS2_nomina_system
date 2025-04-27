<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Empleado;
use App\Models\Hijo;
use App\Models\Parametro;
use App\Services\LiquidacionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LiquidacionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_bonificacion_por_hijos_y_ips()
    {
        Parametro::create(['clave' => 'salario_minimo', 'valor' => 2798309]);

        $empleado = Empleado::factory()->create(['sueldo_base' => 7000000]);

        Hijo::create([
            'id_empleado' => $empleado->id_empleado,
            'fecha_nacimiento' => now()->subYears(10),
        ]);

        $servicio = new LiquidacionService();
        $conceptos = $servicio->calcular($empleado);

        $this->assertCount(3, $conceptos); // Sueldo, bonificación, IPS
        $this->assertEquals(62500, $conceptos[1]['monto']); // 5% de 2.798.309
    }
}
