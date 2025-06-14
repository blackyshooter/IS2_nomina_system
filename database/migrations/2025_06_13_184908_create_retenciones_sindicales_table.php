<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('retenciones_sindicales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->decimal('monto_mensual', 15, 2);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('empleado_id')->references('id_empleado')->on('empleados')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retenciones_sindicales');
    }
};
