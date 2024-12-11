<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Lote;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Carbon;

class CreditoController extends Controller
{
    public function index()
    {
        // Obtener todas las ventas con sus relaciones de contacto y lotes
        $ventas = Venta::with(['lote', 'contacto'])->get(); // Verifica que las relaciones sean correctas
        $contactos = Contacto::all();
        $lotes = Lote::all();

        // Pasar los datos a la vista
        return view('creditos', compact('ventas', 'contactos', 'lotes'));
    }
    public function generarCronogramaPdf($venta_id)
{
    // Obtener la venta específica por su ID
    $venta = Venta::findOrFail($venta_id);
    $contacto = $venta->contacto; // Obtener el contacto relacionado con la venta

    // Calcular la fecha de los pagos restantes, asumiendo que el primer pago es el mismo que la fecha de venta
    $fechaVenta = Carbon::parse($venta->fecha_venta);
    $montoRestante = $venta->precio_venta_final - $venta->enganche;

    // Cargar la vista que generará el cronograma en formato HTML
    $html = view('cronograma', compact('venta', 'contacto', 'fechaVenta', 'montoRestante'))->render();

    // Configuración de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true); // Permite el uso de PHP en el HTML (para cálculos dinámicos)
    $dompdf = new Dompdf($options);

    // Cargar el HTML en Dompdf
    $dompdf->loadHtml($html);

    // Definir el tamaño del papel (A4 por defecto)
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador con un nombre personalizado
    return $dompdf->stream('cronograma_venta_' . $venta->id . '.pdf');
}
public function guardar(Request $request)
{
    // Validar los datos
    $request->validate([
        'meses' => 'nullable|integer|min:1', // Meses es opcional y solo aplica para crédito
    ]);
    
}
}


