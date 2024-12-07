<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención pluralizada
    protected $table = 'meses';

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'nombre', // Puedes agregar más columnas según las necesidades
    ];

    /**
     * Relación con el modelo Venta
     * Un mes puede tener muchas ventas.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
