<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Mostrar lista de contactos
    public function index()
    {
        $contactos = Contacto::all();
        return view('contactos', compact('contactos'));
    }

    // Guardar nuevo contacto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'curp_rfc' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'observacion' => 'nullable|string',
        ]);

        Contacto::create($request->all());

        return redirect()->route('inicio')->with('success', 'Contacto creado exitosamente.');
    }

    // Actualizar contacto existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'curp_rfc' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'observacion' => 'nullable|string',
        ]);

        $contacto = Contacto::findOrFail($id);
        $contacto->update($request->all());

        return redirect()->route('contactos')->with('success', 'Contacto actualizado exitosamente.');
    }

    // Cargar los datos de contacto para edición (AJAX)
    public function edit($id)
    {
        $contacto = Contacto::findOrFail($id);
        return response()->json($contacto);
    }

    // Eliminar contacto
    public function destroy($id)
    {
        $contacto = Contacto::findOrFail($id);
        $contacto->delete();

        return redirect()->route('inicio')->with('success', 'Contacto eliminado exitosamente.');
    }
}
