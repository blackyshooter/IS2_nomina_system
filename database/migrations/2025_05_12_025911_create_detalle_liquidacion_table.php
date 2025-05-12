<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleLiquidacionTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_liquidacion', function (Blueprint $table) {
    $table->id('id_detalle_liquidacion');

    $table->unsignedBigInteger('liquidacion_id');
    $table->foreign('liquidacion_id')->references('id_liquidacion')->on('liquidacion_cabecera')->onDelete('cascade');

    $table->unsignedBigInteger('empleado_id');
    $table->foreign('empleado_id')->references('id_empleado')->on('empleados')->onDelete('cascade');

    $table->unsignedBigInteger('concepto_id');
$table->foreign('concepto_id')->references('id_concepto')->on('conceptos_salariales')->onDelete('cascade');


    $table->decimal('monto', 15, 2);
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('detalle_liquidacion');
    }
}
