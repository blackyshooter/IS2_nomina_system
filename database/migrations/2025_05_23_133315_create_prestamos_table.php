<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            // CAMBIO AQUÍ: Usamos unsignedBigInteger y foreign para referenciar id_empleado
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id_empleado')->on('empleados')->onDelete('cascade');

            $table->decimal('monto_total', 10, 2);
            $table->decimal('monto_cuota', 10, 2);
            $table->integer('cuotas_restantes');
            $table->date('fecha_inicio_pago');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};