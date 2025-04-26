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
    Schema::create('hijos', function (Blueprint $table) {
        $table->bigIncrements('id_hijo');
        $table->unsignedBigInteger('cedula');
        $table->unsignedBigInteger('id_empleado');

        $table->foreign('cedula')->references('cedula')->on('personas')->onDelete('cascade');
        $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hijos');
    }
};
