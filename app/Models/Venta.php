<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacto_id', 'fecha_venta', 'tipo_venta', 'asesor', 'numero_contrato',
        'aval', 'lote', 'precio_venta_final', 'descripcion', 'observacion',
        'banco_caja_interna', 'comprobante', 'numero_comprobante', 'forma_pago',
        'monto_primer_pago', 'fecha_hora_pago', 'modalidad_enganche', 'cantidad_pagos',
        'fecha_inicio', 'codigo_operacion','lote',
    ];
        // En el modelo Venta
    public function lotes()
    {
        return $this->belongsTo(Lote::class);
    }


    public function pagos() {
        return $this->hasMany(Pago::class);
    }

    public function planPago() {
        return $this->hasOne(PlanPago::class);
    }
     // Relación con Contacto
    // En el modelo Venta
    public function contacto() {
        return $this->belongsTo(Contacto::class);
    }
     
}
