<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyIdUsuarioAutoincrementInUsersTable extends Migration
{
    public function up()
    {
        // Esto es específico para PostgreSQL: cambiar la columna a serial
        // Primero se debe eliminar la restricción de PK y la columna, luego crearla como serial

        Schema::table('users', function (Blueprint $table) {
            // Para cambiar a serial, se hace raw SQL porque Laravel no tiene método directo
            DB::statement('ALTER TABLE users DROP COLUMN id_usuario CASCADE');
            DB::statement('ALTER TABLE users ADD COLUMN id_usuario SERIAL PRIMARY KEY');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir los cambios a tipo entero sin serial/autoincrement
            DB::statement('ALTER TABLE users DROP COLUMN id_usuario CASCADE');
            DB::statement('ALTER TABLE users ADD COLUMN id_usuario INTEGER PRIMARY KEY');
        });
    }
}

