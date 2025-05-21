<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hijo extends Model
{
    //use HasFactory;

    protected $table = 'hijos';
    protected $fillable = ['id_persona', 'id_empleado'];
}