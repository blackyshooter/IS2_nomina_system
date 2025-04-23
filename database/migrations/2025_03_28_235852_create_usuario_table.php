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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('id_usuario')->nullable()->unique(); // para login alternativo
            $table->string('rol')->default('empleado');          // para redirección por rol
            $table->unsignedBigInteger('empleado_id')->nullable(); // para asociar al empleado
            $table->boolean('debe_cambiar_password')->default(true); // opcional
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
