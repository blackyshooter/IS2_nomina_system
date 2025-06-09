<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ausencias', function (Blueprint $table) {
            $table->id();
            // CAMBIO AQUÍ: Usamos unsignedBigInteger y foreign para referenciar id_empleado
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id_empleado')->on('empleados')->onDelete('cascade');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('dias_ausente');
            $table->string('tipo_ausencia');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ausencias');
    }
};