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
        // Obtener el proyecto_id de la sesión (o cualquier otro medio)
        $proyectoId = session('proyecto_id');  // Asegúrate de que esta variable esté definida

        // Consultar los lotes relacionados con el proyecto actual
        $lotes = Lote::with('manzana')
                    ->where('proyecto_id', $proyectoId) // Filtrar por proyecto_id
                    ->paginate(10);

        // Obtener todas las manzanas para el formulario
        $manzanas = Manzana::all();

        // Pasar los lotes y las manzanas a la vista
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
            'estado' => 'required|in:activo,inactivo,cancelado,reservado,disponible,vendido',
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

        // Asignar un valor predeterminado a 'venta_id' si no se proporciona
        $validated['venta_id'] = $validated['venta_id'] ?? 1; // Cambia 1 por el ID predeterminado que consideres adecuado

        // Añadir el proyecto_id desde la sesión
        $validated['proyecto_id'] = session('proyecto_id');  // Añadir el proyecto_id desde la sesión

        // Crear el nuevo lote
        Lote::create($validated);

        // Redirigir con un mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Lote creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un lote.
     */
    public function edit($id)
    {
        $lote = Lote::findOrFail($id);
        $manzanas = Manzana::all(); // Obtener todas las manzanas para el formulario
        return view('edit_lote', compact('lote', 'manzanas'));
    }

    /**
     * Actualiza un lote en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'manzana_id' => 'required|exists:manzanas,id',
            'denominacion' => 'required|string|max:255',
            'costo_aproximado' => 'required|numeric|min:0',
            'precio_venta_contado' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo,cancelado,reservado,disponible,vendido',
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
            'lote' => 'required|string|max:255',
            'precio_venta_final' => 'required|numeric|min:0',
            'area' => 'nullable|numeric',
        ]);

        $lote = Lote::findOrFail($id);
        $lote->update($validated);

        return redirect()->route('inicio')->with('success', 'Lote actualizado correctamente.');
    }

    /**
     * Elimina un lote de la base de datos.
     */
    public function destroy($id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();

        return redirect()->route('inicio')->with('success', 'Lote eliminado exitosamente.');
    }
}
