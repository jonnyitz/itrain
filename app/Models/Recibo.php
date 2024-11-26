<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacto_id',
        'monto',
        'tipo_recibo',
        'fecha',
        'correlativo',
        'metodo_pago',
        'concepto',
    ];

    // Relación con Contactos
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    // Relación con Gastos Proyecto
    public function GastoProyecto()
    {
        return $this->belongsTo(GastoProyecto::class);
    }
}
