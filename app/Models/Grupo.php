<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Grupo
class Grupo extends Model
{
    protected $fillable = ['descripcion', 'empresa_id'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}