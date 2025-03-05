<?php

namespace App\Http\Controllers;

use App\Models\GastoProyecto;
use Illuminate\Http\Request;

class GastoProyectoController extends Controller
{
    public function index(Request $request)
{
    // Obtener el ID del proyecto desde la sesión
    $proyectoId = session('proyecto_id');

    // Validar que el usuario tenga un proyecto seleccionado
    if (!$proyectoId) {
        return redirect()->back()->with('error', 'No hay un proyecto seleccionado.');
    }

    // Obtener el término de búsqueda
    $search = $request->input('search');

    // Construcción de la consulta
    $gastos = GastoProyecto::where('proyecto_id', $proyectoId) // Filtrar por proyecto
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('concepto', 'like', '%' . $search . '%')
                  ->orWhere('observacion', 'like', '%' . $search . '%');
            });
        })
        ->paginate(10);

    return view('gastos_proyecto', compact('gastos', 'search'));
}
    public function store(Request $request)
    {
        // Validación de los datos
        $data = $request->validate([
            'concepto' => 'required|string',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'observacion' => 'nullable|string',
            'constancia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'metodo_pago' => 'required|string',
        ]);
    
        // Agregar el proyecto_id desde la sesión
        $data['proyecto_id'] = session('proyecto_id');
    
        // Si se carga una imagen, guardarla y asignar la ruta
        if ($request->hasFile('constancia')) {
            $data['constancia'] = $request->file('constancia')->store('constancias', 'public');
        }
    
        // Crear el gasto en la base de datos
        GastoProyecto::create($data);
    
        return redirect()->route('gastos_proyecto.index')->with('success', 'Gasto agregado correctamente.');
    }
    public function edit($id)
    {
        $gasto = GastoProyecto::findOrFail($id); // Busca el gasto por ID
        return view('gastos_p_edit', compact('gasto')); // Carga la vista con los datos
    }
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $data = $request->validate([
            'concepto' => 'required|string',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'observacion' => 'nullable|string',
            'constancia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'metodo_pago' => 'required|string',
        ]);

        $gasto = GastoProyecto::findOrFail($id); // Busca el gasto

        // Si se carga una nueva imagen, guárdala y actualiza la ruta
        if ($request->hasFile('constancia')) {
            $imagenPath = $request->file('constancia')->store('constancias', 'public');
            $data['constancia'] = $imagenPath;
        }

        $gasto->update($data); // Actualiza el gasto

        return redirect()->route('inicio')->with('success', 'Gasto actualizado correctamente');
    }
    public function destroy($id)
    {
        // Buscar el gasto por ID
        $gasto = GastoProyecto::findOrFail($id);

        // Eliminar el gasto
        $gasto->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Gasto eliminado correctamente.');
    }



}
