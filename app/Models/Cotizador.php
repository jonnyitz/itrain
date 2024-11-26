<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizador extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'cotizadores';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre',
    ];

    // Relación con el modelo Contacto (uno a muchos)
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    // Relación uno a muchos con el modelo Lote
    public function lotes()
    {
        return $this->hasMany(Lote::class, 'cotizador_id');
    }
}
