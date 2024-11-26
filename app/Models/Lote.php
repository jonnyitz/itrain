<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    // Especifica la tabla asociada al modelo
    protected $table = 'lotes';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'venta_id',
        'lote',
        'precio_venta_final',
        'descripcion',
        'observacion',
    ];

    // Relación con la tabla ventas (un lote pertenece a una venta)
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function cotizador()
    {
        return $this->belongsTo(Cotizador::class, 'cotizador_id');
    }
}
