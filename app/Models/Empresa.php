<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Empresa
class Empresa extends Model
{
    protected $fillable = ['nombre'];

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }
}
