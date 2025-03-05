<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;

class ConceptoController extends Controller
{
    public function index(Request $request)
    {
        // Obtén el ID del proyecto de la sesión
        $proyectoId = session('proyecto_id'); // O también lo puedes obtener de la solicitud con $request->input('proyecto_id')

        // Realiza la consulta para filtrar los conceptos por proyecto
        $conceptos = Concepto::where('proyecto_id', $proyectoId)->get();

        return view('conceptos', compact('conceptos'));
    }
    public function edit($id)
    {
        $concepto = Concepto::findOrFail($id);
        return view('editar_concepto', compact('concepto'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'concepto' => 'required|string|max:255',
            'tipo_concepto' => 'required|string|max:255',
        ]);

        // Agregar el proyecto_id a la creación del concepto
        $proyectoId = session('proyecto_id');
        Concepto::create(array_merge($request->only(['concepto', 'tipo_concepto']), ['proyecto_id' => $proyectoId]));

        return redirect()->back()->with('success', 'Concepto creado exitosamente');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'concepto' => 'required|string|max:255',
            'tipo_concepto' => 'required|string|max:255',
        ]);

        // Obtener el concepto y actualizarlo
        $concepto = Concepto::findOrFail($id);
        $concepto->update([
            'concepto' => $request->input('concepto'),
            'tipo_concepto' => $request->input('tipo_concepto'),
            'proyecto_id' => session('proyecto_id'), // Si deseas mantener el mismo proyecto_id
        ]);

        return redirect()->route('inicio')->with('success', 'Concepto actualizado exitosamente');
    }


    public function destroy($id)
    {
        $concepto = Concepto::findOrFail($id);
        $concepto->delete();

        return redirect()->back()->with('success', 'Concepto eliminado exitosamente');
    }
}
