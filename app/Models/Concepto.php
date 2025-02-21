<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;


    protected $fillable = [
        'concepto', 'tipo_concepto', 'proyecto_id'
    ];
    // Modelo Concepto

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

}

