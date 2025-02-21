<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\Empresa;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::with('empresa')->get();
        $empresas = Empresa::all();
        return view('sedes', compact('sedes', 'empresas'));
    }

    public function create()
    {
        $empresas = Empresa::all();
        return view('sedes', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sede' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefonos' => 'required|string|max:255',
            'pais' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'localidad' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:sedes,email',
            'empresa_id' => 'required|exists:empresas,id',
        ]);
    
       
        Sede::create($request->all());
        return redirect()->route('sedes.index')->with('success', 'Sede creada exitosamente.');
    }

    public function show($id)
    {
        $sede = Sede::with('empresa')->findOrFail($id);
        return view('sedes.show', compact('sede'));
    }

    
    public function update(Request $request, $id)
{
    $sede = Sede::findOrFail($id);
    $sede->update($request->all());

    return redirect()->route('sedes.index')->with('success', 'Sede actualizada con éxito.');
}

    public function destroy($id)
    {
        $sede = Sede::findOrFail($id);
        $sede->delete();

        return redirect()->route('sedes')->with('success', 'Sede eliminada exitosamente.');
    }
}
