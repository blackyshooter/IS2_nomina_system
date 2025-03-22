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
    Schema::create('personas', function (Blueprint $table) {
        $table->unsignedBigInteger('cedula')->primary();
        $table->string('nombre', 25);
        $table->string('apellido', 25);
        $table->date('fecha_nacimiento');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
