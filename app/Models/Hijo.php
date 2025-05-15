<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hijo extends Model
{
    use HasFactory;

    protected $table = 'hijos';
    protected $primaryKey = 'id_hijo';

    protected $fillable = ['id_empleado', 'nombre', 'apellido', 'fecha_nacimiento'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }
}
