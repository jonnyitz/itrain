<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteLotes extends Model
{
    use HasFactory;

    protected $table = 'reportes_lotes'; // Nombre de la tabla
    protected $fillable = ['descripcion', 'monto', 'fecha']; // Campos asignables
}
