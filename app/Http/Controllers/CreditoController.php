<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Lote;
use App\Models\Proyecto;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Carbon;

class CreditoController extends Controller
{
    public function index()
    {
        // Obtener todas las ventas con sus relaciones de contacto y lotes
       // Obtener solo las ventas a crédito
       $proyectoId = session('proyecto_id');  // Asegúrate de que esta variable esté definida
       $ventas = Venta::with(['lote', 'contacto'])
       ->where('modalidad_enganche', '2') // Filtrar solo ventas a crédito
       ->where('proyecto_id', $proyectoId) // Filtrar por proyecto_id
       ->paginate(10);

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
    public function generarEnganche($id)
    {
        function numeroALetras($num) {
            $unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];
            $decenas = ["", "", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
            $centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
            $mil = ["mil", "un mil", "mil"];
            $milMillon = "millón";
        
            $num = (int)$num;
        
            if ($num == 0) return "cero";
        
            // Para valores hasta 999,999
            if ($num < 1000) {
                if ($num < 100) {
                    return ($num < 20) ? $unidades[$num] : $decenas[(int)($num / 10)] . ($num % 10 ? " y " . $unidades[$num % 10] : "");
                } else {
                    $cent = (int)($num / 100);
                    return $centenas[$cent] . (($num % 100) ? " " . numeroALetras($num % 100) : "");
                }
            } elseif ($num < 1000000) {  // Maneja miles
                $milUnit = (int)($num / 1000);
                $resto = $num % 1000;
                return ($milUnit > 1 ? numeroALetras($milUnit) . " " : "") . $mil[0] . ($resto ? " " . numeroALetras($resto) : "");
            } elseif ($num < 1000000000) { // Maneja millones
                $millones = (int)($num / 1000000);
                $resto = $num % 1000000;
                return numeroALetras($millones) . " " . $milMillon . ($resto ? " " . numeroALetras($resto) : "");
            } else {
                return "Número fuera de rango";
            }
        }
        // Obtén la venta seleccionada
        $venta = Venta::findOrFail($id); // Obtiene la venta por ID
        $fechaActual = Carbon::now()->format('d-m-Y'); // Fecha actual usando Carbon
    
        // Llamar a la función convertirNumeroALetras
        $numeroALetras = NumeroALetras($venta->enganche);
        $contacto = $venta->contacto; // Asumiendo que la relación está bien definida
        $proyectoId = session('proyecto_id');
    
        // Intentar obtener el proyecto con ese id
        $proyecto = Proyecto::find($proyectoId);
    
        // Verificar si el proyecto fue encontrado
        if (!$proyecto) {
            dd("Proyecto no encontrado con el id: " . $proyectoId);
        }
    
        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
    
        // Inicializa Dompdf con las opciones
        $dompdf = new Dompdf($options);
    
        // Carga la vista en HTML (pasando solo la venta seleccionada)
        $html = view('enganche', compact('venta', 'fechaActual', 'numeroALetras', 'contacto', 'proyecto'))->render();
    
        // Carga el HTML al Dompdf
        $dompdf->loadHtml($html);
    
        // Configurar tamaño carta (8.5 x 11 pulgadas)
        $dompdf->setPaper([0, 0, 612, 792], 'portrait'); // 8.5 x 11 pulgadas en puntos (612 x 792)
        // Obtener el número total de páginas
        $totalPages = $dompdf->get_canvas()->get_page_count();
    
        // Agregar folio y número de páginas en el pie de página
        $canvas = $dompdf->getCanvas();
        $canvas->page_text(520, 760, 'Página {PAGE_NUM} de ' . $totalPages, null, 8, array(0, 0, 0));  // Ajusta la posición
    
        // Renderiza el PDF (esto lo convierte en el archivo PDF)
        $dompdf->render();
    
        // Salida del PDF (para descargarlo)
        return $dompdf->stream('venta_' . $id . '_' . $fechaActual . '.pdf');
    }

}


