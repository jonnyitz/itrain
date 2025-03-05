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
    public function edit($id)
    {
        $recibo = Recibo::findOrFail($id);
        return view('editar_recibo', compact('recibo'));
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

        return redirect()->route('inicio')->with('success', 'Recibo agregado correctamente.');
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'monto' => 'required|numeric',
            'tipo_recibo' => 'required|string',
            'fecha' => 'required|date',
            'correlativo' => 'required|string',
            'concepto' => 'required|string',
            'metodo_pago' => 'required|string',
        ]);

        $recibo = Recibo::findOrFail($id);
        $recibo->update($data);

        return redirect()->route('inicio')->with('success', 'Recibo actualizado correctamente.');
    }
    public function destroy($id)
    {
        $recibo = Recibo::findOrFail($id);
        $recibo->delete();
    
        return redirect()->route('inicio')->with('success', 'Recibo eliminado correctamente.');
    }
    
}
