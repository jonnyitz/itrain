<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;
use App\Models\Contacto;
use App\Models\GastoProyecto;

class RecibosController extends Controller
{
    public function index()
    {
        $recibos = Recibo::with('contacto', 'GastoProyecto')->get();
        $contactos = Contacto::all();
        $gastos = GastoProyecto::all();

        return view('recibos', compact('recibos', 'contactos', 'gastos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'monto' => 'required|numeric',
            'tipo_recibo' => 'required|string',
            'fecha' => 'required|date',
            'correlativo' => 'required|string',
            'concepto' => 'required|string',
            'metodo_pago'=> 'required|string',
            
        ]);

        Recibo::create($data);

        return redirect()->route('recibos')->with('success', 'Recibo agregado correctamente.');
    }
}
