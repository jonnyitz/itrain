<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProyectoAjustesController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all();
        return view('proyecto-ajustes', compact('proyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'ubicacion' => 'required',
            'moneda' => 'required',
            'total_lotes' => 'required|numeric',
            'lotes_disponibles' => 'required|numeric',
            'estado' => 'required',
            'imagen' => 'nullable|image',
        ]);

        $proyecto = new Proyecto($request->all());

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName(); // Nombre único
            $rutaImagen = 'imagenes/' . $nombreImagen;
            
            $imagen->move(public_path('imagenes'), $nombreImagen); // Guarda en public/imagenes
            
            $proyecto->imagen = $rutaImagen; // Guarda la ruta en la BD
        }
        
        $proyecto->save();
    

        return redirect()->route('proyecto-ajustes.index')->with('success', 'Proyecto agregado exitosamente.');
    }
    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id); // Encuentra el proyecto por su ID
        return view('proyectos_edit', compact('proyecto'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required',
            'ubicacion' => 'required',
            'moneda' => 'required',
            'total_lotes' => 'required|numeric',
            'lotes_disponibles' => 'required|numeric',
            'estado' => 'required',
            'imagen' => 'nullable|image',
        ]);

        $proyecto = Proyecto::findOrFail($id); // Encuentra el proyecto que se desea editar

        // Actualiza los datos del proyecto
        $proyecto->nombre = $request->nombre;
        $proyecto->ubicacion = $request->ubicacion;
        $proyecto->moneda = $request->moneda;
        $proyecto->total_lotes = $request->total_lotes;
        $proyecto->lotes_disponibles = $request->lotes_disponibles;
        $proyecto->estado = $request->estado;

        $proyecto = Proyecto::findOrFail($id); // Encuentra el proyecto que se desea editar

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName(); // Nombre único
            $rutaImagen = 'imagenes/' . $nombreImagen;
            
            $imagen->move(public_path('imagenes'), $nombreImagen); // Guarda en public/imagenes
            
            $proyecto->imagen = $rutaImagen; // Guarda la ruta en la BD
        }
        
        $proyecto->save();
    

        return redirect()->route('inicio')->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if ($proyecto->imagen) {
            \Storage::disk('public')->delete($proyecto->imagen);
        }
        $proyecto->delete();

        return redirect()->route('inicio')->with('success', 'Proyecto eliminado correctamente.');
    }
}


