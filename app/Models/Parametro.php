<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    use HasFactory;

    protected $table = 'parametros';

    protected $fillable = ['clave', 'valor'];

   

    /**
     * Obtiene el valor de un parámetro dado su clave.
     *
     * @param string $clave
     * @return string|null Retorna el valor del parámetro o null si no existe.
     */
    public static function obtenerValor(string $clave)
    {
        $parametro = self::where('clave', $clave)->first();

        return $parametro ? $parametro->valor : null;
    }
}
