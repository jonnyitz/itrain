<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Contacto;
use App\Models\Venta;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $proyectoId = session('proyecto_id');  // Asegúrate de que esta variable esté definida

        $reservas = Reserva::with('contacto', 'venta')
        ->where('proyecto_id', $proyectoId) // Filtrar por proyecto_id
        ->get();
        $contactos = Contacto::all();
        $ventas = Venta::all();

        return view('reservas', compact('reservas', 'contactos', 'ventas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'venta_id' => 'required|exists:ventas,id',
            'fecha_firma' => 'required|date',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric',
        ]);

        // Asume que el contacto también debe tener un proyecto_id asociado
        $reservas = $request->all();
        $reservas['proyecto_id'] = session('proyecto_id');  // Añadir el proyecto_id
        Reserva::create($reservas);
        
        Reserva::create([
            'contacto_id' => $request->contacto_id,
            'venta_id' => $request->venta_id,
            'fecha_firma' => $request->fecha_firma,
            'fecha_pago' => $request->fecha_pago,
            'monto' => $request->monto,
        ]);

        return redirect()->route('inicio')->with('success', 'Reserva creada exitosamente.');
    }

    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);
        $contactos = Contacto::all();
        $ventas = Venta::all();

        return response()->json([
            'reserva' => $reserva,
            'contactos' => $contactos,
            'ventas' => $ventas
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'venta_id' => 'required|exists:ventas,id',
            'fecha_firma' => 'required|date',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric',
        ]);

        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'contacto_id' => $request->contacto_id,
            'venta_id' => $request->venta_id,
            'fecha_firma' => $request->fecha_firma,
            'fecha_pago' => $request->fecha_pago,
            'monto' => $request->monto,
        ]);

        return redirect()->route('inicio')->with('success', 'Reserva actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('inicio')->with('success', 'Reserva eliminada exitosamente.');
    }
}
