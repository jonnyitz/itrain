<?php

namespace App\Http\Controllers;

use App\Models\GastosGenerales;
use Illuminate\Http\Request;

class GastosGeneralesController extends Controller
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
        $gastos = GastosGenerales::where('proyecto_id', $proyectoId) // Filtrar por proyecto
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('concepto', 'like', '%' . $search . '%')
                      ->orWhere('observacion', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);
    
        return view('gastos_generales', compact('gastos', 'search'));
    }
    

    public function store(Request $request)
    {
        $data = $request->validate([
            'concepto' => 'required|string',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'observacion' => 'nullable|string',
            'constancia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'metodo_pago' => 'required|string',
        ]);
      // Si se carga una imagen, guárdala en el almacenamiento y guarda la ruta
      if ($request->hasFile('constancia')) {
        // Guardamos la imagen en el disco 'custom' en la carpeta 'constancias'
        $imagenPath = $request->file('constancia')->store('constancias', 'public');
        // Asignamos la ruta al campo 'constancia' del array $data
        $data['constancia'] = $imagenPath; // Cambio de $data->constancia a $data['constancia']
    }
    // Agregar el proyecto_id desde la sesión
    $data['proyecto_id'] = session('proyecto_id');
    
    // Si se carga una imagen, guardarla y asignar la ruta
    if ($request->hasFile('constancia')) {
        $data['constancia'] = $request->file('constancia')->store('constancias', 'public');
    }


        GastosGenerales::create($data);

        return redirect()->route('inicio')->with('success', 'Gasto agregado correctamente.');
    }
    public function edit($id)
    {
        $gasto = GastosGenerales::findOrFail($id); // Reemplaza TuModelo con el nombre de tu modelo
        return view('gastos_edit', compact('gasto')); // Carga la vista con los datos
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'concepto' => 'required|string',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'observacion' => 'nullable|string',
            'constancia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'metodo_pago' => 'required|string',
        ]);

        $gasto = GastosGenerales::findOrFail($id); // Busca el gasto

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
        $gasto = GastosGenerales::findOrFail($id);

        // Eliminar el gasto
        $gasto->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Gasto eliminado correctamente.');
    }



}
