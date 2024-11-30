<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manzana extends Model
{
    use HasFactory;
     // Especifica la tabla asociada al modelo
     protected $table = 'manzanas';

    protected $fillable = ['nombre', 'proyecto_id'];

    // Relación con el modelo Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
     // Relación con lotes (una manzana tiene muchos lotes)
     public function lotes()
     {
         return $this->hasMany(Lote::class, 'manzana_id');
     }
}
