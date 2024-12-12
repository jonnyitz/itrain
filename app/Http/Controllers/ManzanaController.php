<?php

namespace App\Http\Controllers;

use App\Models\Manzana;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ManzanaController extends Controller
{
    public function index()
    {
        $manzanas = Manzana::with('proyecto')->get();
        $proyectos = Proyecto::all(); // Para mostrar en el formulario

        return view('manzanas', compact('manzanas', 'proyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'proyecto_id' => 'required|exists:proyectos,id',
            'vendedor' => 'required|string|max:255',
        ]);

        Manzana::create($request->all());

        return redirect()->route('inicio')->with('success', 'Manzana registrada exitosamente.');
    }
    public function destroy($id)
    {
        // Buscar el usuario por su ID
        $manzanas = Manzana::findOrFail($id);

        // Eliminar el usuario
        $manzanas->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Manzana eliminada');
    }
}
