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
    Schema::table('empleados', function (Blueprint $table) {
        $table->decimal('salario_base', 15, 2)->default(0)->after('nombre'); // o después de otro campo
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('empleados', function (Blueprint $table) {
        $table->dropColumn('salario_base');
    });
}
};
