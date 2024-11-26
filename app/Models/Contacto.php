<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'curp_rfc',
        'telefono',
        'direccion',
        'observacion',
    ];
    // Relación con el modelo Pago (si un contacto tiene múltiples pagos)
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'contacto_id');
    }

    // Relación con el modelo Venta (si un contacto tiene múltiples ventas)
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'contacto_id');
    }
}


