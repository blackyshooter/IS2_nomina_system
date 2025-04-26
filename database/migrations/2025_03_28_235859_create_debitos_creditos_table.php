<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('debitos_creditos', function (Blueprint $table) {
            $table->bigIncrements('id_deb_cr');
            $table->float('monto');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // Definir claves foráneas correctamente
            $table->unsignedBigInteger('id_concepto');
            $table->unsignedBigInteger('id_empleado');

            $table->foreign('id_concepto')->references('id_concepto')->on('conceptos_salariales')->cascadeOnDelete();
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debitos_creditos');
    }
};
