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
        'manzana_id',         // Agregamos manzana_id
        'venta_id',
        'lote',
        'costo_aproximado',
        'precio_venta_contado',
        'precio_venta_final',
        'descripcion',
        'medida_frontal',
        'medida_costado_derecho',
        'medida_costado_izquierdo',
        'medida_posterior',
        'colindancia_frontal',
        'colindancia_derecho',
        'colindancia_izquierdo',
        'colindancia_posterior',
        'precio_m2',
        'observacion',
        'area',
        'estado',
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
    public function manzana()
    {
        return $this->belongsTo(Manzana::class);
    }
}
