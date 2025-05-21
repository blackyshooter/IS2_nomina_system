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
        $table->id(); // clave primaria autoincremental (puede omitirse si usás clave compuesta)
        $table->unsignedBigInteger('id_persona');   // hijo
        $table->unsignedBigInteger('id_empleado');  // padre o madre

        // Claves foráneas
        $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
        $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');

        $table->timestamps();
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
