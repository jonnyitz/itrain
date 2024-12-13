<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Grupo
class Grupo extends Model
{
    protected $fillable = ['descripcion', 'empresa_id', 'nombre'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}