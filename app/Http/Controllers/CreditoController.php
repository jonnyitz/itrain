<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Lote;

// app/Http/Controllers/CreditoController.php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Lote;

class CreditoController extends Controller
{
    public function index()
    {
        // Obtener todas las ventas con sus relaciones de contacto y lotes
        $ventas = Venta::with(['lote', 'contacto'])->get(); // Verifica que las relaciones sean correctas
        $contactos = Contacto::all();
        $lotes = Lote::all();

        // Pasar los datos a la vista
        return view('creditos', compact('ventas', 'contactos', 'lotes'));
    }
    
}


