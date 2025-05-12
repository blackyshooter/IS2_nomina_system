<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionCabeceraTable extends Migration
{
    public function up()
    {
        Schema::create('liquidacion_cabecera', function (Blueprint $table) {
            $table->id('id_liquidacion');
            $table->date('fecha_liquidacion');
            $table->string('periodo');
            $table->decimal('monto_total', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('liquidacion_cabecera');
    }
}
