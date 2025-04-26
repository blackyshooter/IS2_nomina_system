<?php
// database/migrations/2025_04_25_000003_create_liquidaciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionesTable extends Migration
{
    public function up()
    {
        Schema::create('liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')
                  ->constrained('empleados', 'id_empleado') // Especifica la tabla y la columna
                ->onDelete('cascade');
            $table->foreignId('concepto_id')
                  ->constrained('conceptos_salariales', 'id_concepto') // Referencia la columna id (por defecto)
                ->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('liquidaciones');
    }
}
