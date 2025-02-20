<?php

namespace App\Http\Controllers;

use App\Models\Proyecto; // Asegúrate de que el modelo Proyecto está importado
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all(); // Obtener todos los proyectos
        return view('proyectos', compact('proyectos')); // Pasar proyectos a la vista
    }
    // Otros métodos (create, store, edit, update, destroy) aquí...
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'total_lotes' => 'required|integer',
            'lotes_disponibles' => 'required|integer',
            'estado' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
            'moneda' => 'required|string|max:255',
        ]);
    
        $proyecto = new Proyecto();
        $proyecto->nombre = $request->nombre;
        $proyecto->ubicacion = $request->ubicacion;
        $proyecto->total_lotes = $request->total_lotes;
        $proyecto->lotes_disponibles = $request->lotes_disponibles;
        $proyecto->estado = $request->estado;
        $proyecto->moneda = $request->moneda;
    
        // Si se carga una imagen, guárdala en el almacenamiento y guarda la ruta
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('proyectos', 'public');
            $proyecto->imagen = $imagenPath;
        }
    
        $proyecto->save();
    
        return redirect()->back()->with('success', 'Proyecto creado exitosamente.');
    }
        public function filtrar(Request $request)
    {
        $filtro = $request->input('filtro');

        $proyectos = Proyecto::where('nombre', 'like', "%$filtro%")
                            ->orWhere('ubicacion', 'like', "%$filtro%")
                            ->get();

        return view('proyectos', compact('proyectos'));
    }
     // Método para seleccionar un proyecto
     public function seleccionarProyecto($id)
     {
         $proyecto = Proyecto::findOrFail($id); // Buscar el proyecto por su id
         session(['proyecto_id' => $proyecto->id]); // Almacenar el proyecto en la sesión
 
         // Redirigir a la página principal o a donde desees
         return redirect()->route('inicio')->with('success', 'Proyecto seleccionado exitosamente');
     }
 

    
}
