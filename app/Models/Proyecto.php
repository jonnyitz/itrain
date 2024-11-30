<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ubicacion', // Cambiado de descripcion a ubicacion
        'moneda',
        'total_de_lotes',
        'lotes_disponibles',
        'estado',
        'imagen', // Añadir 'imagen' a la lista de fillable
    ];

    // Puedes agregar relaciones si es necesario
    public function manzanas()
    {
        return $this->hasMany(Manzana::class);
    }
}
