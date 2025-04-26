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
    Schema::create('cargos_ocupados', function (Blueprint $table) {
        $table->bigIncrements('id_cargo');
        $table->float('asignacion');
        $table->date('fecha_inicio');
        $table->date('fecha_fin')->nullable();
        $table->unsignedBigInteger('id_empleado');
        $table->unsignedBigInteger('id_area');

        $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
        $table->foreign('id_area')->references('id_area')->on('areas')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos_ocupados');
    }
};
