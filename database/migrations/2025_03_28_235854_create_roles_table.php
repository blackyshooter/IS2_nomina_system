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
    Schema::create('roles', function (Blueprint $table) {
        $table->bigIncrements('id_rol');
        $table->string('nombre_rol', 25);
        $table->string('descripcion', 25);
        $table->unsignedBigInteger('id_usuario');

        $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
