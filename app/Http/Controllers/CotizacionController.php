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
            'fecha_primer_pago' => 'required|date',
            'primer_pago_enganche' => 'required|numeric|min:0',
            'precio_venta_final' => 'required|numeric|min:0',
            'modalidad' => 'required|string', // Validación para modalidad

        ]);

        // Crear una nueva cotización
        Cotizacion::create([
            'contacto_id' => $request->contacto_id,
            'lote_id' => $request->lote_id,
            'cotizador_id' => $request->cotizador_id,
            'tipo_id' => $request->tipo_id,
            'fecha_primer_pago' => $request->fecha_primer_pago,
            'primer_pago_enganche' => $request->primer_pago_enganche,
            'precio_venta_final' => $request->precio_venta_final,
            'modalidad' => $request->modalidad, // Almacenamiento de modalidad

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
