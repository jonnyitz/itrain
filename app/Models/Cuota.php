<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención de nombres)
    protected $table = 'cuotas';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'contacto_id',
        'lote_id',
        'comprobante',
        'n_cts',
        'tipo',
        'fecha',
        'rd',
        'voucher',
        'banco_id', // Nuevo campo
        'concep',
        'cuotas',
        'forma_de_pago',
        'monto',
        'proyecto_id',

    ];

    // Relaciones con otros modelos
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
        public function banco()
    {
        return $this->belongsTo(Banco::class);
    }
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
