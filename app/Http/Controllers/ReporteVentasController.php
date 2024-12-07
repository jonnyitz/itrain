<?php

namespace App\Http\Controllers;

use App\Models\Manzana;
use App\Models\Venta;
use App\Models\Contacto; // Asumiendo que Contacto es el modelo para los clientes
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteVentasController extends Controller
{
    // Método para mostrar la vista principal
    public function index()
    {
        // Obtener las manzanas
        $manzanas = Manzana::all();

        // Obtener los tipos de venta (suponiendo que están en el modelo Venta)
        $tiposDeVenta = \App\Models\Venta::select('tipo_venta')->distinct()->get();

        // Obtener los vendedores (suponiendo que están en el modelo Venta)
        $vendedores = \App\Models\Manzana::select('vendedor')->distinct()->get();

        // Retornar la vista con los datos
        return view('r_ventas', compact('manzanas', 'tiposDeVenta', 'vendedores'));
    }

    // Método para generar el PDF
    public function generarPDF(Request $request)
    {
        // Filtrar las ventas de acuerdo a los filtros proporcionados en la solicitud
        $query = Venta::query();

        // Filtrar por manzana si se pasa el ID de la manzana
        if ($request->has('manzana') && $request->manzana != 'todas') {
            $query->whereHas('manzana', function ($q) use ($request) {
                $q->where('id', $request->manzana);
            });
        }

        // Filtrar por tipo de venta
        if ($request->has('tipo_venta') && $request->tipo_venta != 'todas') {
            $query->where('tipo_venta', $request->tipo_venta);
        }

        // Filtrar por vendedor
        if ($request->has('vendedor') && $request->vendedor != 'todos') {
            $query->where('vendedor', $request->vendedor);
        }

        // Obtener las ventas filtradas
        $ventas = $query->with(['manzana', 'contacto'])->get();  // Asumimos que la relación 'contacto' es para los clientes

        // Retornar la vista para el PDF
        $pdf = Pdf::loadView('reporte_ventas', compact('ventas'));

        // Devolver el PDF generado
        return $pdf->stream('reporte_ventas.pdf');
    }

    public function detalleVentaPDF()
    {
        // Obtener los datos necesarios agrupados por cliente
        $ventas = Venta::selectRaw('contacto_id, manzana_id, COUNT(*) as cantidad, SUM(monto_primer_pago) as total, MAX(fecha_hora_pago) as ultima_fecha')
            ->groupBy('contacto_id', 'manzana_id') // Agrupar por cliente y manzana
            ->with(['contacto', 'manzana']) // Relacionar con contacto y manzana
            ->get();

        // Generar el PDF con los datos obtenidos
        $pdf = PDF::loadView('detalle_venta', compact('ventas'));

        // Mostrar el PDF en el navegador
        return $pdf->stream('detalle_venta.pdf');
    }
    public function ventasPorVendedor(Request $request)
    {
        // Obtener datos de la base de datos
        $ventas = Venta::with(['manzana', 'lote', 'contacto'])
            ->when($request->vendedor, function ($query, $vendedor) {
                if ($vendedor !== 'todos') {
                    $query->where('vendedor', $vendedor);
                }
            })
            ->get();

        // Calcular el total de las ventas
        $totalVentas = $ventas->sum('precio_venta_final');

        // Pasar los datos a la vista del PDF
        $data = [
            'ventas' => $ventas,
            'totalVentas' => $totalVentas,
            'vendedorSeleccionado' => $request->vendedor ?? 'Todos los Agentes de Ventas',
            'fechaInicio' => $request->fecha_inicio ?? '01/12/2024',
            'fechaFin' => $request->fecha_fin ?? '31/12/2024',
        ];

        $pdf = PDF::loadView('reporte_ventas_por_vendedor', $data);

        return $pdf->stream('ventas_por_vendedor.pdf'); // Mostrar el PDF
    }
}
