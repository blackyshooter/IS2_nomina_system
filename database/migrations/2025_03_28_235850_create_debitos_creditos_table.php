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

        $table->unsignedBigInteger('id_concepto');
        $table->unsignedBigInteger('id_empleado');

        $table->foreignId('id_concepto')->constrained('conceptos_salariales')->cascadeOnDelete();      
        $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
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
