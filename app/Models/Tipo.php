<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tipos';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre',
    ];
}
