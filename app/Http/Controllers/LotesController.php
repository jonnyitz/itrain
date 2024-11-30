<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Manzana;
use Illuminate\Http\Request;

class LotesController extends Controller
{
    /**
     * Muestra la lista de lotes.
     */
    public function index()
    {
        $lotes = Lote::with('manzana')->get(); // Obtener todos los lotes con su manzana asociada
        $manzanas = Manzana::all(); // Obtener todas las manzanas para el formulario
        return view('lotes', compact('lotes', 'manzanas'));
    }

    /**
     * Guarda un nuevo lote en la base de datos.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'manzana_id' => 'required|exists:manzanas,id',
        'denominacion' => 'required|string|max:255',
        'costo_aproximado' => 'required|numeric|min:0',
        'precio_venta_contado' => 'required|numeric|min:0',
        'estado' => 'required|in:disponible,vendido',
        'descripcion' => 'required|string',
        'medida_frontal' => 'required|numeric|min:0',
        'medida_costado_derecho' => 'required|numeric|min:0',
        'medida_costado_izquierdo' => 'required|numeric|min:0',
        'medida_posterior' => 'required|numeric|min:0',
        'colindancia_frontal' => 'required|string',
        'colindancia_derecho' => 'required|string',
        'colindancia_izquierdo' => 'required|string',
        'colindancia_posterior' => 'required|string',
        'observacion' => 'nullable|string',
        'precio_m2' => 'required|numeric|min:0',
        'lote' => 'required|string|max:255', // Asegúrate de que el campo lote sea obligatorio si es necesario
        'precio_venta_final' => 'required|numeric|min:0',  // Asegúrate de que este campo se valide
        'area' => 'nullable|numeric', // Validar el nuevo campo

        
    ]);
                         $validated['venta_id'] = $validated['venta_id'] ?? 1; // Cambia 1 por el ID predeterminado que consideres adecuado


                         

    Lote::create($validated);

    return redirect()->route('lotes')->with('success', 'Lote creado correctamente.');
}

    public function destroy($id)
    {
        $lotes= Lote::findOrFail($id);
        $lotes->delete();

        return redirect()->route('lotes')->with('success', 'Lote eliminado exitosamente.');
    }
}
