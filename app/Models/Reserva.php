<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacto_id',
        'venta_id',
        'fecha_firma',
        'fecha_pago',
        'monto',
        'proyecto_id',
    ];

    // Relación con Contacto
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    // Relación con Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
