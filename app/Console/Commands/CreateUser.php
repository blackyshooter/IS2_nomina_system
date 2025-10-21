<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:create {email} {password} {nombre_usuario} {id_rol}';

    /**
     * The console command description.
     */
    protected $description = 'Crear un nuevo usuario en el sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $nombre_usuario = $this->argument('nombre_usuario');
        $id_rol = $this->argument('id_rol');

        // Verificar si el usuario ya existe
        if (User::where('email', $email)->exists()) {
            $this->error('El usuario con este correo ya existe.');
            return;
        }

        // Crear el usuario
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'nombre_usuario' => $nombre_usuario,
            'id_rol' => $id_rol,
        ]);

        $this->info("Usuario {$user->nombre_usuario} creado exitosamente.");
    }
}
