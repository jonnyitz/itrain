<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Venta;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function index()
    {
        $bancos = Banco::all();
        return view('bancos', compact('bancos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_banco' => 'required|string',
            'tipo_cuenta' => 'required|string',
            'moneda' => 'required|string',
            'numero_cuenta' => 'required|string',
            'cci' => 'required|string',
            'nombre_responsable' => 'required|string',
           
        ]);

        Banco::create($request->all());
        return back()->with('success', 'Banco creado con éxito');
    }
    public function destroy($id)
    {
        // Encontrar el banco por su ID
        $banco = Banco::findOrFail($id);
    
        // Eliminar el banco
        $banco->delete();
    
        // Redirigir con mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Banco eliminado exitosamente');
    }    
}
