<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Manzana;
use App\Models\Venta;
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
        $ventas = $query->with(['manzana', 'contacto'])->get();
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

    public function cuotasPorCobrarPDF()
    {
        // Consultar las ventas que no tienen primer pago (simulando "pendiente")
        $ventas = Venta::whereNull('monto_primer_pago') // Filtra ventas que no tienen monto de primer pago
            ->with(['contacto', 'manzana']) // Relacionar con cliente y manzana
            ->get();

        // Estructurar los datos para el PDF
        $cuotas = $ventas->map(function ($venta) {
            return [
                'cliente' => $venta->contacto->nombre ?? 'N/A',
                'lote_manzana' => $venta->manzana->nombre ?? 'N/A',
                'telefono' => $venta->contacto->telefono ?? 'N/A',
                'fecha_pago' => optional($venta->fecha_hora_pago)->format('d/m/Y') ?? 'No definida',
                'tipo_cuota' => $venta->tipo_cuota ?? 'No definida', // Cambiar según el atributo real
                'cantidad' => $venta->cantidad_cuotas ?? 0, // Ajustar según el campo que corresponda
                'monto' => $venta->monto_primer_pago ?? 0, // Ajustar según el campo real
                'total' => $venta->precio_venta_final ?? 0, // Ajustar según el total
            ];
        });

        // Sumar totales
        $totalCuotas = $cuotas->sum('cantidad');
        $montoTotal = $cuotas->sum('total');

        // Preparar los datos para la vista
        $data = [
            'cuotas' => $cuotas,
            'totalCuotas' => $totalCuotas,
            'montoTotal' => $montoTotal,
            'proyecto' => 'ARCES', // Puedes hacerlo dinámico según necesidad
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('cuotas_por_cobrar', $data);
        return $pdf->stream('cuotas_por_cobrar.pdf');
    }
    public function ventasCompletadasPDF()
    {
        $lotes = Lote::where('estado', 'completado') // Filtrar lotes completados
            ->whereHas('venta', function ($query) { // Usar la relación con ventas para filtrar por tipo de venta
                $query->where('tipo_venta', 'crédito'); // Filtrar ventas de tipo "crédito"
            })
            ->with(['contacto', 'manzana', 'venta']) // Cargar relaciones necesarias (cliente, manzana y venta)
            ->get();
        // Estructurar los datos para el PDF
        $ventasCompletadas = $lotes->map(function ($lote) {
            return [
                'cliente' => $lote->contacto->nombre ?? 'N/A', // Obtener el nombre del cliente
                'lote_manzana' => $lote->manzana->nombre ?? 'N/A', // Obtener el nombre de la manzana
                'fecha_venta' => optional($lote->venta->fecha_venta)->format('d/m/Y') ?? 'No definida', // Obtener la fecha de venta
                'precio_venta' => $lote->venta->precio_venta_final ?? 0, // Obtener el precio final de la venta
            ];
        });

        // Sumar el total de las ventas completadas
        $totalVentas = $ventasCompletadas->sum('precio_venta');

        // Preparar los datos para la vista
        $data = [
            'ventas' => $ventasCompletadas,
            'totalVentas' => $totalVentas,
            'proyecto' => 'ARCES', // Puedes hacerlo dinámico según necesidad
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('ventas_completadas', $data);
        return $pdf->stream('ventas_completadas.pdf');
    }


    public function ventasAnuladasPDF()
    {
        $lotes = Lote::where('estado', 'completado') // Filtrar lotes completados
            ->whereHas('venta', function ($query) { // Usar la relación con ventas para filtrar por tipo de venta
                $query->where('tipo_venta', 'crédito'); // Filtrar ventas de tipo "crédito"
            })
            ->with(['contacto', 'manzana', 'venta']) // Cargar relaciones necesarias (cliente, manzana y venta)
            ->get();
        // Estructurar los datos para el PDF
        $ventasAnuladas = $lotes->map(function ($lote) {
            return [
                'cliente' => $lote->contacto->nombre ?? 'N/A', // Obtener el nombre del cliente
                'lote_manzana' => $lote->manzana->nombre ?? 'N/A', // Obtener el nombre de la manzana
                'fecha_venta' => optional($lote->venta->fecha_venta)->format('d/m/Y') ?? 'No definida', // Obtener la fecha de venta
                'precio_venta' => $lote->venta->precio_venta_final ?? 0, // Obtener el precio final de la venta
            ];
        });

        // Sumar el total de las ventas completadas
        $totalVentas = $ventasAnuladas->sum('precio_venta');

        // Preparar los datos para la vista
        $data = [
            'ventas' => $ventasAnuladas,
            'totalVentas' => $totalVentas,
            'proyecto' => 'ARCES', // Puedes hacerlo dinámico según necesidad
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('ventas_anuladas', $data);
        return $pdf->stream('ventas_anuladas.pdf');
    }
}
