<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\Contacto;
use App\Models\Lote;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
        public function index()
    {
        $cuotas = Cuota::with(['contacto', 'lote'])->get();
        $contactos = Contacto::all(); // Asumiendo que tienes un modelo `Contacto`
        $lotes = Lote::all(); // Asumiendo que tienes un modelo `Lote`

        return view('cuotas', compact('cuotas', 'contactos', 'lotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contacto_id' => 'required',
            'lote_id' => 'required',
            'comprobante' => 'required',
            'n_cts' => 'required',
            'tipo' => 'required',
            'fecha' => 'required|date',
            'rd' => 'nullable',
            'voucher' => 'nullable',
        ]);

        Cuota::create($request->all());
        return redirect()->route('inicio')->with('success', 'Cuota creada exitosamente.');
    }
}
