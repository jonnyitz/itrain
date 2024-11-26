<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Contacto;
use App\Models\Lote;
use App\Models\Cotizador;
use App\Models\Tipo;

class CotizacionController extends Controller
{
    // Método para mostrar la vista de cotizaciones
    public function index()
    {
        // Obtener todas las cotizaciones junto con sus relaciones
        $cotizaciones = Cotizacion::with('contacto', 'lote', 'cotizador', 'tipo')->get();
        $contactos = Contacto::all();
        $lotes = Lote::all();
        $cotizadores = Cotizador::all();
        $tipos = Tipo::all();
    
        // Retornar la vista 'cotizaciones' con los datos
        return view('cotizaciones', compact('cotizaciones', 'contactos', 'lotes', 'cotizadores', 'tipos'));
    }
    

    // Método para almacenar una nueva cotización
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'lote_id' => 'required|exists:lotes,id',
            'cotizador_id' => 'required|exists:cotizadores,id',
            'tipo_id' => 'required|exists:tipos,id',
        ]);

        // Crear una nueva cotización
        Cotizacion::create([
            'contacto_id' => $request->contacto_id,
            'lote_id' => $request->lote_id,
            'cotizador_id' => $request->cotizador_id,
            'tipo_id' => $request->tipo_id,
        ]);

        // Redirigir de vuelta a la página de cotizaciones con un mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Cotización creada con éxito.');
    }
    public function destroy($id)
    {
        $contacto = Cotizacion::findOrFail($id);
        $contacto->delete();

        return redirect()->route('inicio')->with('success', 'Contacto eliminado exitosamente.');
    }
}
