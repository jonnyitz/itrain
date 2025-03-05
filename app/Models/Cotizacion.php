<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones'; // Asegúrate de definir correctamente el nombre de la tabla

    protected $fillable = [
        'contacto_id',
        'lote_id',
        'cotizador_id',
        'tipo_id',
        'modalidad',
        'fecha_primer_pago',
        'primer_pago_enganche',
        'precio_venta_final',
        // agrega los demás campos necesarios
    ];

    // Relación con el modelo Contacto
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    // Relación con el modelo Lote
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    // Relación con el modelo Cotizador
    public function cotizador()
    {
        return $this->belongsTo(Cotizador::class);
    }

    // Relación con el modelo Tipo
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
