<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptosSalarialesTable extends Migration
{
    public function up()
    {
        Schema::create('conceptos_salariales', function (Blueprint $table) {
            $table->id('id_concepto');
            $table->enum('tipo_concepto', ['credito', 'debito']);
            $table->string('descripcion');
            $table->boolean('fijo')->default(false);
            $table->boolean('afecta_ips')->default(false);
            $table->boolean('afecta_aguinaldo')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conceptos_salariales');
    }
}
