<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastosGenerales extends Model
{
    use HasFactory;

    protected $table = 'gastos_generales';

    protected $fillable = [
        'concepto',
        'monto',
        'fecha',
        'observacion',
        'constancia',
        'metodo_pago',
        'proyecto_id',
    ];
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
