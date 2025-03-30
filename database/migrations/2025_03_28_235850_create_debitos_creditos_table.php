<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitosCreditosTable extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debitos_creditos', function (Blueprint $table) {
            $table->id('id_deb_cr'); // Clave primaria auto-incremental
            $table->float('monto', 8, 2); // Columna para el monto
            $table->date('fecha_inicio'); // Columna para la fecha de inicio
            $table->date('fecha_fin')->nullable(); // Columna para la fecha de fin, que puede ser nula
            $table->unsignedBigInteger('id_concepto'); // Clave foránea a conceptos_salariales
            $table->unsignedBigInteger('id_empleado'); // Clave foránea a empleados
            $table->timestamps(); // Campos created_at y updated_at

            // Relaciones
            $table->foreign('id_concepto')->references('id_concepto')->on('conceptos_salariales')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
        });
    }

    /**
     * Revierte la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debitos_creditos');
    }
}