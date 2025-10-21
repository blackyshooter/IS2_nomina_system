<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    protected $signature = 'user:reset-password {email} {password}';
    protected $description = 'Restablece la contraseña de un usuario';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('Usuario no encontrado.');
            return;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info('Contraseña actualizada correctamente.');
    }
}