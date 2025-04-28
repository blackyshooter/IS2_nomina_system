<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_rol');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('id_rol')->references('id_rol')->on('roles')->onDelete('cascade');

            $table->unique(['id_usuario', 'id_rol']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
