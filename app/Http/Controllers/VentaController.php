<?php

namespace App\Http\Controllers;

use App\Models\Venta;

use App\Models\Contacto;
use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\Manzana;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Carbon;

class VentaController extends Controller
{
    // Mostrar el formulario de creación de una nueva venta
    public function create()
    {
        $contactos = Contacto::all(); // Obtener todos los contactos
        $lotes = Lote::all(); // Obtener todos los lotes
        $manzanas= Manzana::all();

        return view('ventas', compact('manzanas','contactos', 'lotes'));
    }

    // Almacenar una nueva venta en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'lote_id' => 'nullable|exists:lotes,id',
            'manzana_id' => 'required|exists:manzanas,id',
            'fecha_venta' => 'required|date',
            'tipo_venta' => 'required|string',
            'asesor' => 'required|string',
            'numero_contrato' => 'required|string',
            'aval' => 'nullable|string',
            'precio_venta_final' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'banco_caja_interna' => 'required|string',
            'comprobante' => 'required|string',
            'numero_comprobante' => 'required|string',
            'forma_pago' => 'required|string',
            'monto_primer_pago' => 'required|numeric',
            'fecha_hora_pago' => 'required|date',
            'codigo_operacion' => 'required|string',
            'modalidad_enganche' => 'required|string',
            'enganche' => 'required|numeric',
            'cantidad_pagos' => 'required|integer',
            'fecha_inicio' => 'required|date',
        ]);

        // Crear una nueva venta
        Venta::create([
            'contacto_id' => $request->contacto_id,
            'lote_id' => $request->lote_id,
            'manzana_id' => $request->manzana_id,
            'fecha_venta' => $request->fecha_venta,
            'tipo_venta' => $request->tipo_venta,
            'asesor' => $request->asesor,
            'numero_contrato' => $request->numero_contrato,
            'aval' => $request->aval,
            'precio_venta_final' => $request->precio_venta_final,
            'descripcion' => $request->descripcion,
            'observacion' => $request->observacion,
            'banco_caja_interna' => $request->banco_caja_interna, // Campo independiente
            'comprobante' => $request->comprobante,
            'numero_comprobante' => $request->numero_comprobante,
            'forma_pago' => $request->forma_pago,
            'monto_primer_pago' => $request->monto_primer_pago,
            'fecha_hora_pago' => $request->fecha_hora_pago,
            'codigo_operacion' => $request->codigo_operacion,
            'modalidad_enganche' => $request->modalidad_enganche,
            'enganche' => $request->enganche,
            'cantidad_pagos' => $request->cantidad_pagos,
            'fecha_inicio' => $request->fecha_inicio,
        ]);

        // Redirigir con éxito
        return redirect()->route('ventas')->with('success', 'Venta registrada exitosamente');
    }

    // Mostrar todas las ventas
    public function index()
    {
        $ventas = Venta::all(); // Obtener todas las ventas
        $contactos = Contacto::all(); // Obtener todos los contactos
        $lotes = Lote::all(); // Obtener todos los lotes
        $manzanas= Manzana::all();



        return view('ventas', compact('manzanas','contactos','ventas', 'lotes' ));
    }

    // Mostrar detalles de una venta específica
    public function show($id)
    {
        $venta = Venta::findOrFail($id); // Buscar la venta por ID

        return view('ventas.show', compact('venta'));
    }

    // Mostrar el formulario para editar una venta
    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $contactos = Contacto::all();
        $lotes = Lote::all();
        $manzanas= Manzana::all();

        return view('ventas.edit', compact('manzanas','venta', 'contactos', 'lotes'));
    }

    // Actualizar una venta en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'contacto_id' => 'exists:contactos,id',
            'lote_id' => 'required|exists:lotes,id',
            'manzana_id' => 'required|exists:manzanas,id',
            'fecha_venta' => 'required|date',
            'tipo_venta' => 'required|string',
            'asesor' => 'required|string',
            'numero_contrato' => 'required|string',
            'aval' => 'nullable|string',
            'precio_venta_final' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'banco_caja_interna' => 'required|string',
            'comprobante' => 'required|string',
            'numero_comprobante' => 'required|string',
            'forma_pago' => 'required|string',
            'monto_primer_pago' => 'required|numeric',
            'fecha_hora_pago' => 'required|date',
            'codigo_operacion' => 'required|string',
            'modalidad_enganche' => 'required|string',
            'enganche' => 'required|numeric',
            'cantidad_pagos' => 'required|integer',
            'fecha_inicio' => 'required|date',
        ]);

        $venta = Venta::findOrFail($id);
        $venta->update([
            'contacto_id' => $request->contacto_id,
            'lote_id' => $request->lote_id,
            'manzana_id' => $request->manzanas_id,
            'fecha_venta' => $request->fecha_venta,
            'tipo_venta' => $request->tipo_venta,
            'asesor' => $request->asesor,
            'numero_contrato' => $request->numero_contrato,
            'aval' => $request->aval,
            'precio_venta_final' => $request->precio_venta_final,
            'descripcion' => $request->descripcion,
            'observacion' => $request->observacion,
            'banco_caja_interna' => $request->banco_caja_interna,
            'comprobante' => $request->comprobante,
            'numero_comprobante' => $request->numero_comprobante,
            'forma_pago' => $request->forma_pago,
            'monto_primer_pago' => $request->monto_primer_pago,
            'fecha_hora_pago' => $request->fecha_hora_pago,
            'codigo_operacion' => $request->codigo_operacion,
            'modalidad_enganche' => $request->modalidad_enganche,
            'enganche' => $request->enganche,
            'cantidad_pagos' => $request->cantidad_pagos,
            'fecha_inicio' => $request->fecha_inicio,
        ]);

        return redirect()->route('ventas')->with('success', 'Venta actualizada exitosamente');
    }

    // Eliminar una venta
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return redirect()->route('inicio')->with('success', 'Venta eliminada exitosamente');
    }
    public function generarPagare($venta_id)
{
    // Obtener la venta
    $venta = Venta::findOrFail($venta_id);
    $contacto = $venta->contacto; // Obtener el contacto de la venta

    // Calcular las fechas de los pagos (suponiendo que el primer pago es la fecha de venta y luego se agrega un mes por cada pagare)
    $fechaVenta = Carbon::parse($venta->fecha_venta);
    
    // Cargar el HTML que se pasará a Dompdf
    $html = view('pagare', compact('venta', 'contacto', 'fechaVenta'))->render();

    // Configuración de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true); // Permite PHP en el HTML (para calcular fechas)
    $dompdf = new Dompdf($options);

    // Cargar el HTML en Dompdf
    $dompdf->loadHtml($html);

    // (Opcional) Definir el tamaño de la página
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
    return $dompdf->stream('pagare_' . $venta->numero_contrato . '.pdf');
}
    
}
