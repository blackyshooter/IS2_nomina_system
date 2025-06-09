<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptosEmpleadosTable extends Migration
{
    public function up()
    {
        Schema::create('conceptos_empleados', function (Blueprint $table) {
            $table->id();
            // Referencia a 'id_empleado' en lugar de 'id'
            $table->foreignId('empleado_id')->constrained('empleados', 'id_empleado')->onDelete('cascade');
            $table->foreignId('concepto_id')->constrained('conceptos_salariales', 'id_concepto');
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        });
        Schema::table('conceptos_empleados', function (Blueprint $table) {
            $table->decimal('monto_mensual', 10, 2)->nullable();
            $table->decimal('monto_total', 15, 2)->nullable(); // Hasta alcanzar este monto
            $table->date('fecha_inicio')->nullable(); // Inicio del embargo
            $table->date('fecha_fin')->nullable(); // Fecha límite
        });
    }

    public function down()
    {
        Schema::dropIfExists('conceptos_empleados');
    }
}
