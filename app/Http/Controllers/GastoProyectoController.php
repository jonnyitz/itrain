<?php

namespace App\Http\Controllers;

use App\Models\GastoProyecto;
use Illuminate\Http\Request;

class GastoProyectoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $gastos = GastoProyecto::where('concepto', 'like', '%' . $search . '%')
                    ->orWhere('observacion', 'like', '%' . $search . '%')
                    ->paginate(10);

        return view('gastos_proyecto', compact('gastos', 'search'));
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


        GastoProyecto::create($data);

        return redirect()->route('gastos_proyecto.index')->with('success', 'Gasto agregado correctamente.');
    }
}
