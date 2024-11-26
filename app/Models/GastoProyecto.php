<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoProyecto extends Model
{
    use HasFactory;

    protected $table = 'gastos_proyecto';

    protected $fillable = [
        'concepto',
        'monto',
        'fecha',
        'observacion',
        'constancia',
        'metodo_pago',
    ];
}
