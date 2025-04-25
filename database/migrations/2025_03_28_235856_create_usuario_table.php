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
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('id_usuario', 25)->primary(); // PK tipo string
            $table->string('email', 25)->unique();
            $table->string('password', 255); 
            $table->string('nombre_usuario', 25);
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_rol'); // Relación directa con roles
        
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
            $table->foreign('id_rol')->references('id_rol')->on('roles')->onDelete('restrict');
        
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
