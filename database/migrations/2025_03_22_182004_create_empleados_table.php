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
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('id_empleado');
            $table->unsignedBigInteger('cedula');
            $table->string('telefono', 25);
            $table->float('sueldo_base');
            $table->date('fecha_ingreso');
            $table->string('cargo', 25);
            $table->timestamps();
    
            $table->foreign('cedula')->references('cedula')->on('personas')->onDelete('cascade');
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
