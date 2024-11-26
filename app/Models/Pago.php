<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    // Especifica la tabla asociada al modelo
    protected $table = 'pagos';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'venta_id',
        'banco_caja_interna',
        'comprobante',
        'numero_comprobante',
        'forma_pago',
        'monto_primer_pago',
        'fecha_hora_pago',
        'codigo_operacion',
        'venta_id',
    ];

    // Relación con la tabla ventas (un pago pertenece a una venta)
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto_id');
    }
}
