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
        Schema::create('areas', function (Blueprint $table) {
            $table->bigIncrements('id_area');
            $table->string('nombre_area', 40);
            $table->date('fecha_creacion');
            $table->string('activa', 1);
            $table->unsignedBigInteger('id_area_superior')->nullable();
            $table->foreign('id_area_superior')->references('id_area')->on('areas')->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
