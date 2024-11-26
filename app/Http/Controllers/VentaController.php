<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Lote;
use App\Models\Pago;
use App\Models\PlanPago;
use App\Models\Contacto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index() {
        $contactos = Contacto::all();
        $pagos = Pago::distinct()->get(['id', 'banco_caja_interna', 'forma_pago']);
        
        // Obtener las ventas con las relaciones necesarias
        $ventas = Venta::with(['lotes', 'pagos', 'planPago', 'contacto'])->get(); // Verifica que las relaciones sean correctas
        return view('ventas', compact('ventas', 'contactos', 'pagos'));
    }

    public function store(Request $request) {
        \Log::info('Request Data: ', $request->all());
        $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'fecha_venta' => 'required|date',
            'tipo_venta' => 'required|string|max:255',
            'asesor' => 'required|string|max:255',
            'numero_contrato' => 'required|string|max:255',
            'aval' => 'nullable|string|max:255',
            'lote' => 'required|string|max:255',
            'precio_venta_final' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'banco_caja_interna' => 'required|string|max:255',
            'comprobante' => 'required|string|max:255',
            'numero_comprobante' => 'required|string|max:255',
            'forma_pago' => 'required|string|max:255',
            'monto_primer_pago' => 'required|numeric',
            'fecha_hora_pago' => 'required|date',
            'enganche' => 'required|numeric',
            'modalidad_enganche' => 'required|string|max:255',
            'cantidad_pagos' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'codigo_operacion' => 'nullable|string|max:255',
        ]);

        // Crea la venta asociando el contacto
        $venta = Venta::create($request->only([
            'contacto_id', 
            'fecha_venta', 
            'tipo_venta', 
            'asesor', 
            'numero_contrato', 
            'aval',
            'contacto' // Incluye 'contacto' aquí
        ]));

        // Crea el lote asociado a la venta
        Lote::create([
            'venta_id' => $venta->id,
            'lote' => $request->lote,
            'precio_venta_final' => $request->precio_venta_final,
            'descripcion' => $request->descripcion,
            'observacion' => $request->observacion
        ]);

        // Crea el pago asociado a la venta
        Pago::create([
            'venta_id' => $venta->id,
            'banco_caja_interna' => $request->banco_caja_interna,
            'comprobante' => $request->comprobante,
            'numero_comprobante' => $request->numero_comprobante,
            'forma_pago' => $request->forma_pago,
            'monto_primer_pago' => $request->monto_primer_pago,
            'fecha_hora_pago' => $request->fecha_hora_pago,
            'codigo_operacion' => uniqid('op_')
        ]);

        // Crea el plan de pago asociado a la venta
        PlanPago::create([
            'venta_id' => $venta->id,
            'enganche' => $request->enganche,
            'modalidad_enganche' => $request->modalidad_enganche,
            'cantidad_pagos' => $request->cantidad_pagos,
            'fecha_inicio' => $request->fecha_inicio
        ]);

        return redirect()->route('ventas')->with('success', 'Venta registrada con éxito');
    }
}
