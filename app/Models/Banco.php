<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_banco', 'tipo_cuenta', 'moneda', 'numero_cuenta', 'cci', 'nombre_responsable', 
    ];

   
}
