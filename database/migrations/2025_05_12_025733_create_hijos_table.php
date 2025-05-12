<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHijosTable extends Migration
{
    public function up()
    {
        Schema::create('hijos', function (Blueprint $table) {
            $table->id('id_hijo');
            $table->foreignId('empleado_id')->constrained('empleados', 'id_empleado')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hijos');
    }
}
