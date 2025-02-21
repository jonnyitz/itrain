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
            $proyecto->imagen = $request->file('imagen')->store('imagenes', 'public');
        }
        $proyecto->save();

        return redirect()->route('proyecto-ajustes.index')->with('success', 'Proyecto agregado exitosamente.');
    }
    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'moneda' => 'required|string|max:10',
            'total_lotes' => 'required|integer',
            'lotes_disponibles' => 'required|integer',
            'estado' => 'required|string|in:activo,inactivo',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $proyecto->fill($validatedData);

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($proyecto->imagen && Storage::exists('public/' . $proyecto->imagen)) {
                Storage::delete('public/' . $proyecto->imagen);
            }

            // Guardar nueva imagen
            $imagePath = $request->file('imagen')->storeAs('proyectos', uniqid() . '.' . $request->file('imagen')->extension(), 'public');
            $proyecto->imagen = $imagePath;
        }

        $proyecto->save();

        return redirect()->route('proyecto-ajustes')->with('success', 'Proyecto actualizado correctamente.');
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


