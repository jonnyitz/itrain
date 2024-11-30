<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;

class ConceptoController extends Controller
{
    public function index()
    {
        $conceptos = Concepto::all();
        return view('conceptos', compact('conceptos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concepto' => 'required|string|max:255',
            'tipo_concepto' => 'required|string|max:255',
        ]);

        Concepto::create($request->only(['concepto', 'tipo_concepto']));

        return redirect()->back()->with('inicio', 'Concepto creado exitosamente');
    }

    public function destroy($id)
    {
        Concepto::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Concepto eliminado exitosamente');
    }
}
