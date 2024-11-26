<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

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
            $proyecto->imagen = $request->file('imagen')->store('imagenes', 'public');
        }
        $proyecto->save();

        return redirect()->route('proyecto-ajustes.index')->with('success', 'Proyecto agregado exitosamente.');
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if ($proyecto->imagen) {
            \Storage::disk('public')->delete($proyecto->imagen);
        }
        $proyecto->delete();

        return redirect()->route('proyecto-ajustes.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}


