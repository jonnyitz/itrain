<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteFinanciero extends Model
{
    use HasFactory;

    protected $table = 'reportes_financieros'; // Nombre de la tabla
    protected $fillable = ['descripcion', 'monto', 'fecha']; // Campos asignables
}
