<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteLotesController extends Controller
{
    // Método para mostrar la vista inicial
    public function index()
    {
        return view('r_lotes'); // Asegúrate de que la vista existe en resources/views
    }

    // Método para manejar el filtrado
    public function filtrar(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Lógica de filtrado (reemplaza con la consulta a tu base de datos)
        $resultados = []; // Consulta filtrada, por ejemplo, con Eloquent o Query Builder

        // Retorna la vista con los resultados filtrados
        return view('r_lotes', compact('resultados', 'fechaInicio', 'fechaFin'));
    }

    public function totalLotesPDF()
    {
        // Consultar los lotes con la información necesaria
        $lotes = Lote::with('manzana')->get();

        // Estructurar los datos para el PDF
        $data = $lotes->map(function ($lote) {
            return [
                'manzana_lote' => ($lote->manzana->nombre ?? 'N/A') . ' - LOTE ' . $lote->id,
                'area' => $lote->area ?? 'N/A',
                'costo' => $lote->costo_aproximado ?? 0,
                'precio_venta' => $lote->precio_venta_final ?? 0,
                'utilidad' => ($lote->precio_venta_final ?? 0) - ($lote->costo_aproximado ?? 0),
            ];
        });

        // Calcular totales
        $totalCosto = $data->sum('costo');
        $totalVenta = $data->sum('precio_venta');
        $totalUtilidad = $data->sum('utilidad');

        // Preparar datos para la vista
        $viewData = [
            'lotes' => $data,
            'totalCosto' => $totalCosto,
            'totalVenta' => $totalVenta,
            'totalUtilidad' => $totalUtilidad,
            'proyecto' => 'ARCES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('total_lotes', $viewData);
        return $pdf->stream('total_lotes.pdf');
    }
    public function lotesDisponiblesPDF()
    {
        // Consultar los lotes con la información necesaria
        //$lotes = Lote::with('manzana')->get();
        $lotes = Lote::where('estado', 'activo') // Filtrar lotes activos
            ->with('manzana') // Relacionar con la manzana
            ->get();

        // Estructurar los datos para el PDF
        $data = $lotes->map(function ($lote) {
            return [
                'manzana_lote' => ($lote->manzana->nombre ?? 'N/A') . ' - LOTE ' . $lote->id,
                'area' => $lote->area ?? 'N/A',
                'costo' => $lote->costo_aproximado ?? 0,
                'precio_venta' => $lote->precio_venta_final ?? 0,
                'utilidad' => ($lote->precio_venta_final ?? 0) - ($lote->costo_aproximado ?? 0),
            ];
        });

        // Calcular totales
        $totalCosto = $data->sum('costo');
        $totalVenta = $data->sum('precio_venta');
        $totalUtilidad = $data->sum('utilidad');

        // Preparar datos para la vista
        $viewData = [
            'lotes' => $data,
            'totalCosto' => $totalCosto,
            'totalVenta' => $totalVenta,
            'totalUtilidad' => $totalUtilidad,
            'proyecto' => 'ARCES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('lotes_disponibles', $viewData);
        return $pdf->stream('lotes_disponibles.pdf');
    }

    public function lotesInactivosPDF()
    {
        // Consultar los lotes con la información necesaria
        //$lotes = Lote::with('manzana')->get();
        $lotes = Lote::where('estado', 'inactivo') // Filtrar lotes activos
            ->with('manzana') // Relacionar con la manzana
            ->get();

        // Estructurar los datos para el PDF
        $data = $lotes->map(function ($lote) {
            return [
                'manzana_lote' => ($lote->manzana->nombre ?? 'N/A') . ' - LOTE ' . $lote->id,
                'area' => $lote->area ?? 'N/A',
                'costo' => $lote->costo_aproximado ?? 0,
                'precio_venta' => $lote->precio_venta_final ?? 0,
                'utilidad' => ($lote->precio_venta_final ?? 0) - ($lote->costo_aproximado ?? 0),
            ];
        });

        // Calcular totales
        $totalCosto = $data->sum('costo');
        $totalVenta = $data->sum('precio_venta');
        $totalUtilidad = $data->sum('utilidad');

        // Preparar datos para la vista
        $viewData = [
            'lotes' => $data,
            'totalCosto' => $totalCosto,
            'totalVenta' => $totalVenta,
            'totalUtilidad' => $totalUtilidad,
            'proyecto' => 'ARCES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('lotes_inactivos', $viewData);
        return $pdf->stream('lotes_inactivos.pdf');
    }

    public function lotesVendidosPDF()
    {
        // Consultar los lotes con la información necesaria
        $lotes = Lote::with('manzana')->get();

        // Estructurar los datos para el PDF
        $data = $lotes->map(function ($lote) {
            return [
                'manzana_lote' => ($lote->manzana->nombre ?? 'N/A') . ' - LOTE ' . $lote->id,
                'area' => $lote->area ?? 'N/A',
                'precio_venta' => $lote->precio_venta_final ?? 0,
            ];
        });

        // Calcular totales
        $totalVenta = $data->sum('precio_venta');

        // Preparar datos para la vista
        $viewData = [
            'lotes' => $data,
            'totalVenta' => $totalVenta,
            'proyecto' => 'ARCES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('lotes_vendidos', $viewData);
        return $pdf->stream('lotes_vendidos.pdf');
    }
    public function lotesReservadosPDF()
    {
        // Consultar los lotes reservados con su información relacionada
        $lotes = Lote::where('estado', 'reservado') // Filtrar por estado "reservado"
            ->with(['manzana', 'asesor', 'cliente']) // Relacionar con manzana, asesor y cliente
            ->get();

        // Estructurar los datos para el PDF
        $data = $lotes->map(function ($lote) {
            return [
                'asesor' => $lote->asesor->nombre ?? 'N/A', // Nombre del asesor
                'cliente' => $lote->cliente->nombre ?? 'N/A', // Nombre del cliente
                'lote_manzana' => 'LOTE ' . $lote->id . ' - MANZANA ' . ($lote->manzana->nombre ?? 'N/A'),
                'fecha_firma' => optional($lote->fecha_firma)->format('d/m/Y') ?? 'No definida',
                'monto' => $lote->monto_reserva ?? 0, // Ajustar según el campo real
            ];
        });

        // Calcular el monto total de reservas
        $totalMonto = $data->sum('monto');

        // Preparar datos para la vista
        $viewData = [
            'lotes' => $data,
            'totalMonto' => $totalMonto,
            'proyecto' => 'ARCES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('lotes_reservados', $viewData);
        return $pdf->stream('lotes_reservados.pdf');
    }
}
