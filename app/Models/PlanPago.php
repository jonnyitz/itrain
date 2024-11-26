<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPago extends Model
{
    use HasFactory;

    protected $table = 'planes_pago'; // Asegúrate de que el nombre de la tabla sea correcto

    protected $fillable = [
        'venta_id',
        'enganche',
        'modalidad_enganche',
        'cantidad_pagos',
        'fecha_inicio'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
