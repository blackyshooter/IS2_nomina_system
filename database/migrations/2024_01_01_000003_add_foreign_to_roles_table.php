<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });
    }
};
