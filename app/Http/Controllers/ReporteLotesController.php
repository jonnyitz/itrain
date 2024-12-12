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
            'proyecto' => 'LOS ROBLES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('total_lotes', $viewData);
        return $pdf->stream('total_lotes.pdf');
    }
    public function lotesDisponiblesPDF()
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
            'proyecto' => 'LOS ROBLES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('total_lotes', $viewData);
        return $pdf->stream('total_lotes.pdf');
    }

    public function lotesInactivosPDF()
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
            'proyecto' => 'LOS ROBLES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('total_lotes', $viewData);
        return $pdf->stream('total_lotes.pdf');
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
            'proyecto' => 'LOS ROBLES',
            'fecha_reporte' => now()->format('d/m/Y'),
        ];

        // Generar el PDF
        $pdf = Pdf::loadView('total_lotes', $viewData);
        return $pdf->stream('total_lotes.pdf');
    }
}
