<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar
    protected $fillable = [
        'contacto_id',
        'lote_id',
        'manzana_id',
        'meses',
        'fecha_venta',
        'asesor',
        'numero_contrato',
        'aval',
        'precio_venta_final',
        'descripcion',
        'observacion',
        'banco_id', // Este campo no tiene relación con otra tabla
        'comprobante',
        'numero_comprobante',
        'forma_pago',
        'monto_primer_pago',
        'fecha_hora_pago',
        'codigo_operacion',
        'modalidad_enganche',
        'enganche',
        'cantidad_pagos',
        'fecha_inicio',
    ];

    // Relación con la tabla `contactos`
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    // Relación con la tabla `lotes`
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function Reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function manzana()
    {
        return $this->belongsTo(Manzana::class);
    }

    public function getModalidadEngancheNombreAttribute()
    {
        $modalidades = [
            1 => 'Contado',
            2 => 'Crédito',
            // Agrega otras modalidades si es necesario
        ];
    
        return $modalidades[$this->modalidad_enganche] ?? 'Desconocido';
    }
    public static function generarNumeroContrato()
    {
        $ultimaVenta = self::latest('id')->first(); // Obtener la última venta por ID
        return $ultimaVenta 
            ? 'VEN-' . str_pad($ultimaVenta->id + 1, 6, '0', STR_PAD_LEFT) 
            : 'VEN-000001';  // Si no hay ninguna venta, comenzamos con VEN-000001
    }

     // Relación con Banco
     public function banco()
     {
         return $this->belongsTo(Banco::class);
     }
    
}
