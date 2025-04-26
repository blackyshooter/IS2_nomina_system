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
    Schema::create('conceptos_salariales', function (Blueprint $table) {
        $table->bigIncrements('id_concepto');
        $table->string('descripcion', 25);
        $table->string('tipo_concepto'); // ejemplo: 'Descuento' o 'Bonificación'
        $table->string('fijo'); // ejemplo: 'S' o 'N'
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos_salariales');
    }
};
