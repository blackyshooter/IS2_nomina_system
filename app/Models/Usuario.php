<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla
    protected $table = 'usuario'; // ✅ tu tabla se llama 'usuario'

    // Definir la clave primaria
    protected $primaryKey = 'id_usuario'; // ✅ tu PK no es 'id', es 'id_usuario'

    // Si tu tabla NO tiene las columnas 'created_at' y 'updated_at'
    public $timestamps = false; // ✅ deshabilitamos el uso automático de las fechas

    // Especifica los campos que son asignables
    protected $fillable = [
        'email',
        'contraseña',  // Asegúrate de encriptar este campo cuando lo almacenes
        'nombre_usuario',
        'id_empleado'
    ];

    // Si necesitas ocultar el campo 'contraseña' al convertir el modelo a JSON o array
    protected $hidden = [
        'contraseña',  // Protege el campo de la contraseña
    ];

    // Si deseas hacer alguna conversión o establecer accesores y mutadores (opcional)
    // Por ejemplo: Mutador para encriptar la contraseña cuando se guarda en la base de datos
    public function setContraseñaAttribute($value)
    {
        $this->attributes['contraseña'] = bcrypt($value); // Encripta la contraseña antes de guardarla
    }

    // Opcional: si tienes relaciones, puedes definirlas aquí, por ejemplo:
    // public function empleado()
    // {
    //     return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    // }
}
