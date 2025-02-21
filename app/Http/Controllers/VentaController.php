<?php

namespace App\Http\Controllers;

use App\Models\Venta;

use App\Models\Contacto;
use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\Manzana;
use App\Models\Proyecto;
use App\Models\Mes;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Carbon;
use App\Models\Banco;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    // Mostrar el formulario de creación de una nueva venta
    public function create()
    {
        $contactos = Contacto::all(); // Obtener todos los contactos
        $lotes = Lote::all(); // Obtener todos los lotes
        $manzanas= Manzana::all();
        $bancos = Banco::all();
        
        return view('inicio', compact('manzanas','contactos', 'lotes','bancos'));
    }

    // Almacenar una nueva venta en la base de datos
    public function store(Request $request)
    {
        \Log::info($request->all());

        $request->validate([
            'contacto_id' => 'required|exists:contactos,id',
            'lote_id' => 'nullable|exists:lotes,id',
            'manzana_id' => 'required|exists:manzanas,id',
            'meses' => 'nullable|integer|min:1|max:90', // Validación si es necesario
            'fecha_venta' => 'required|date',
            'asesor' => 'required|string',
            'numero_contrato' => 'required|string',
            'aval' => 'nullable|string',
            'precio_venta_final' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'banco_id' => 'nullable|exists:bancos,id',
            'comprobante' => 'required|string',
            'numero_comprobante' => 'required|string',
            'forma_pago' => 'required|string',
            'monto_primer_pago' => 'required|numeric',
            'fecha_hora_pago' => 'required|date',
            'codigo_operacion' => 'required|string',
            'modalidad_enganche' => 'nullable|string',
            'enganche' => 'nullable|numeric',
            'cantidad_pagos' => 'nullable|integer',
        ]);
        if ($request->modalidad_enganche === '2') { // Validaciones específicas para modalidad a crédito
            $request->validate([
                'meses' => 'required|integer|min:1|max:90',
                'enganche' => 'required|numeric',
                'cantidad_pagos' => 'required|integer',
                'monto_primer_pago' => 'required|numeric',
                'fecha_inicio' => 'required|date',

            ]);
        }

        // Asume que el contacto también debe tener un proyecto_id asociado
        $venta = $request->all();
        $venta['proyecto_id'] = session('proyecto_id');  // Añadir el proyecto_id
        Venta::create($venta);

        // Crear una nueva venta
        Venta::create([
            'contacto_id' => $request->contacto_id,
            'lote_id' => $request->lote_id,
            'manzana_id' => $request->manzana_id,
            'meses' => $request->modalidad_enganche === '2' ? $request->meses : null, // Solo guardar si es crédito
            'fecha_venta' => $request->fecha_venta,
            'asesor' => $request->asesor,
            'numero_contrato' => $request->numero_contrato,
            'aval' => $request->aval,
            'precio_venta_final' => $request->precio_venta_final,
            'descripcion' => $request->descripcion,
            'observacion' => $request->observacion,
            'banco_id' => $request->banco_id,  // Este campo ahora se incluye
            'comprobante' => $request->comprobante,
            'numero_comprobante' => $request->numero_comprobante,
            'forma_pago' => $request->forma_pago,
            'monto_primer_pago' => $request->modalidad_enganche== '2' ? $request->monto_primer_pago: null,
            'fecha_hora_pago' => $request->fecha_hora_pago,
            'codigo_operacion' => $request->codigo_operacion,
            'modalidad_enganche' => $request->modalidad_enganche,
            'enganche' => $request->modalidad_enganche === '2' ? $request->enganche : null, // Solo guardar si es crédito
            'cantidad_pagos' => $request->modalidad_enganche === '2' ? $request->cantidad_pagos : null, // Solo guardar si es créd
            'fecha_inicio' => $request->modalidad_enganche === '2' ? $request->fecha_inicio : null,
        ]);
        // Si se ha seleccionado un lote, actualizar su estado a "vendido"
        if ($request->lote_id) {
            $lote = Lote::find($request->lote_id);
            if ($lote) {
                $lote->update(['estado' => 'vendido']);
            }
        }
        // Redirigir con éxito
        return redirect()->route('inicio')->with('success', 'Venta registrada exitosamente');
    }

    // Mostrar todas las ventas
    public function index(Request $request)
{
    $searchTerm = $request->input('search'); // Obtén el término de búsqueda

    $proyectoId = session('proyecto_id'); // O también puedes obtenerlo de la solicitud si lo prefieres: $request->input('proyecto_id')

    // Realiza la consulta para las ventas y sus relaciones
    $ventas = Venta::when($searchTerm, function ($query, $searchTerm) {
        return $query->where('descripcion', 'like', "%{$searchTerm}%")
                     ->orWhereHas('contacto', function ($query) use ($searchTerm) {
                         // Buscamos en la tabla de contactos por nombre, curp_rfc o teléfono
                         $query->where('nombre', 'like', "%{$searchTerm}%")
                               ->orWhere('curp_rfc', 'like', "%{$searchTerm}%")
                               ->orWhere('telefono', 'like', "%{$searchTerm}%");
                     });
                     
    })
    ->where('proyecto_id', $proyectoId) // Filtrar por proyecto
    ->paginate(10); // Paginación de 10 registros
   


    // Obtener datos adicionales
    $contactos = Contacto::all(); // Obtener todos los contactos
    $lotes = Lote::all(); // Obtener todos los lotes
    $manzanas = Manzana::all(); // Obtener todas las manzanas
    $bancos = Banco::all(); // Obtener todos los bancos

    // Devolver la vista con los datos necesarios
    return view('ventas', compact('ventas', 'contactos', 'lotes', 'manzanas', 'bancos'));
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
        $meses= Mes::all();

        return view('ventas.edit', compact('manzanas','venta', 'contactos', 'lotes'));
    }

    // Actualizar una venta en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'contacto_id' => 'exists:contactos,id',
            'lote_id' => 'required|exists:lotes,id',
            'manzana_id' => 'required|exists:manzanas,id',
            'meses' => 'required|integer|min:1|max:90', // Validación si es necesario
            'fecha_venta' => 'required|date',
            'asesor' => 'required|string',
            'numero_contrato' => 'required|string',
            'aval' => 'nullable|string',
            'precio_venta_final' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'banco_id' => 'nullable|exists:bancos,id',
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
            'meses' => $request->meses, // Guardar el valor de meses
            'fecha_venta' => $request->fecha_venta,
            'asesor' => $request->asesor,
            'numero_contrato' => $request->numero_contrato,
            'aval' => $request->aval,
            'precio_venta_final' => $request->precio_venta_final,
            'descripcion' => $request->descripcion,
            'observacion' => $request->observacion,
            'banco_id' => $request->banco_id,  // Este campo ahora se incluye
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

        return redirect()->route('inicio')->with('success', 'Venta actualizada exitosamente');
    }

    // Eliminar una venta
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        if ($venta->lote_id) {
            $lote = Lote::find($venta->lote_id);
            if ($lote) {
                $lote->update(['estado' => 'disponible']);
            }
        }

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
    public function guardar(Request $request)
    {
        // Validar los datos
        $request->validate([
            'meses' => 'nullable|integer|min:1', // Meses es opcional y solo aplica para crédito
        ]);
        
    }
    public function buscarContactos(Request $request)
    {
        $query = $request->input('q');

        // Buscar por nombre o apellidos
        $contactos = Contacto::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('apellidos', 'LIKE', "%{$query}%")
            ->get(['id', 'nombre', 'apellidos']); // Incluir columna apellidos

        return response()->json($contactos);
    }
    public function getLotesPorManzana($manzana_id)
    {
        // Validar que la manzana exista
        $manzana = Manzana::findOrFail($manzana_id);

        // Obtener los lotes relacionados con esta manzana cuyo estado sea 'disponible' o 'activo'
        $lotes = Lote::where('manzana_id', $manzana_id)
                    ->whereIn('estado', ['disponible', 'activo']) // Filtrar por estado
                    ->get(['id', 'lote']);

        // Devolver los lotes en formato JSON
        return response()->json(['lotes' => $lotes]);
    }

    public function descargarContrato($ventaId)
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
        
        // Obtener los datos de la venta y el contacto
        $venta = Venta::with('contacto')->findOrFail($ventaId);
        $contacto = $venta->contacto;
        $precioEnLetras = numeroALetras($venta->precio_venta_final); // Asegúrate de que esta función exista
        $engancheEnLetras = numeroALetras($venta->enganche); 
        // Obtener el proyecto relacionado, verificar si existe

        $proyectoId = session('proyecto_id');

        // Intentar obtener el proyecto con ese id
        $proyecto = Proyecto::find($proyectoId);

        // Verificar si el proyecto fue encontrado
        if (!$proyecto) {
            dd("Proyecto no encontrado con el id: " . $proyectoId);
        }

        // Cargar la vista HTML del contrato
        $html = view('contrato', compact('venta', 'contacto', 'precioEnLetras','engancheEnLetras', 'proyecto'))->render();

        // Configurar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->setIsHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

            // Configurar tamaño carta (8.5 x 11 pulgadas)
            $dompdf->setPaper([0, 0, 612, 792], 'portrait'); // 8.5 x 11 pulgadas en puntos (612 x 792)


        // Renderizar el PDF
        $dompdf->render();
        // Obtener el número total de páginas
        $totalPages = $dompdf->get_canvas()->get_page_count();

          // Agregar folio y número de páginas en el pie de página
          $canvas = $dompdf->getCanvas();
          $canvas->page_text(520, 760, 'Página {PAGE_NUM} de ' . $totalPages, null, 8, array(0, 0, 0));  // Ajusta la posición
  

        // Generar un nombre dinámico para el archivo PDF
        $filename = 'contrato_' . Carbon::now()->format('Ymd_His') . '.pdf';

        // Retornar el PDF para descarga
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
    public function generarContratoCredito($ventaId)
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

        // Obtener los datos de la venta y el contacto
        $venta = Venta::with('contacto')->findOrFail($ventaId);
        $contacto = $venta->contacto;
        $precioEnLetras = numeroALetras($venta->precio_venta_final); // Asegúrate de que esta función exista
        $engancheEnLetras = numeroALetras($venta->enganche); 
        $montoEnLetras = numeroALetras($venta->monto_primer_pago);
        // Obtener el proyecto relacionado, verificar si existe

        $proyectoId = session('proyecto_id');

        // Intentar obtener el proyecto con ese id
        $proyecto = Proyecto::find($proyectoId);

        // Verificar si el proyecto fue encontrado
        if (!$proyecto) {
            dd("Proyecto no encontrado con el id: " . $proyectoId);
        }

        // Comprobar si la modalidad es de crédito
        if ($venta->modalidad_enganche == 2 || $venta->credito) {
            // Si la modalidad es de crédito, cargar la vista del contrato a crédito
            $html = view('contrato_meses', compact('venta', 'contacto','precioEnLetras','engancheEnLetras','montoEnLetras', 'proyecto'))->render();
        } else {
            // Redirigir si no es modalidad crédito (puedes cambiar la ruta de redirección si lo necesitas)
            return redirect()->route('ventas'); 
        }
    
        // Configurar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->setIsHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);

    
        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);
    
            // Configurar tamaño carta (8.5 x 11 pulgadas)
        $dompdf->setPaper([0, 0, 612, 792], 'portrait'); // 8.5 x 11 pulgadas en puntos (612 x 792)

        // Renderizar el PDF
        $dompdf->render();
           // Obtener el número total de páginas
        $totalPages = $dompdf->get_canvas()->get_page_count();

        // Agregar folio y número de páginas en el pie de página
        $canvas = $dompdf->getCanvas();
        $canvas->page_text(520, 760, 'Página {PAGE_NUM} de ' . $totalPages, null, 8, array(0, 0, 0));  // Ajusta la posición

    
        // Generar un nombre dinámico para el archivo PDF
        $filename = 'contrato_credito_' . Carbon::now()->format('Ymd_His') . '.pdf';
    
        // Retornar el PDF para descarga
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
        public function descargarPDF($id)
    {
        // Buscar la venta y el contacto asociado
        $venta = Venta::with('lote', 'contacto')->findOrFail($id);

        // Generar el PDF con la vista
        $pdf = Pdf::loadView('diferido', compact('venta'));

        // Descargar el PDF
        return $pdf->download('diferido');
    }
    public function generarCartaFiniquito($ventaId) 
    {
        // Función para convertir números a letras
        function numeroALetras($num) {
            $unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];
            $decenas = ["", "", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
            $centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
            $mil = ["mil", "un mil", "mil"];
            $milMillon = "millón";
    
            $num = (int)$num;
    
            if ($num == 0) return "cero";
    
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
    
        // Obtener la venta por su ID
        $venta = Venta::with('contacto')->findOrFail($ventaId);
        $contacto = $venta->contacto;
    
        // Convertir el monto de la venta a letras
        $numeroALetras = numeroALetras($venta->precio_venta_final); 
        $areaEnLetras = numeroALetras($venta->lote->area);
    
        // Obtener el proyecto relacionado a partir de la sesión
        $proyectoId = session('proyecto_id');
        $proyecto = Proyecto::find($proyectoId);
    
        // Verificar si el proyecto fue encontrado
        if (!$proyecto) {
            dd("Proyecto no encontrado con el id: " . $proyectoId);
        }
    
        // Obtener los lotes relacionados con la venta
        // Obtener las manzanas si es necesario
        $manzanas = Manzana::all();  // Puedes ajustar esto según lo que necesites mostrar de las manzanas
    
        // Cargar la vista de la carta finiquito con los datos
        $view = view('carta_finiquito', compact('venta', 'contacto', 'numeroALetras', 'proyecto', 'areaEnLetras'))->render();
    
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        
        // Crear una instancia de Dompdf
        $dompdf = new Dompdf($options);
        
        // Cargar el contenido HTML
        $dompdf->loadHtml($view);
        
          // Configurar tamaño carta (8.5 x 11 pulgadas)
          $dompdf->setPaper([0, 0, 612, 792], 'portrait'); // 8.5 x 11 pulgadas en puntos (612 x 792)

        
        // Renderizar el PDF (esto genera el archivo PDF)
        $dompdf->render();
        
        // Descargar el PDF generado
        return $dompdf->stream('carta_finiquito.pdf', ['Attachment' => 0]); // El 0 significa que se abrirá en el navegador en lugar de descargarlo automáticamente
    }
    public function generarCartaFiniquitoContado($ventaId) 
    {
        // Función para convertir números a letras
        function numeroALetras($num) {
            $unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];
            $decenas = ["", "", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
            $centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
            $mil = ["mil", "un mil", "mil"];
            $milMillon = "millón";
    
            $num = (int)$num;
    
            if ($num == 0) return "cero";
    
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
    
        // Obtener la venta por su ID
        $venta = Venta::with('contacto')->findOrFail($ventaId);
        $contacto = $venta->contacto;
    
        // Convertir el monto de la venta a letras
        $numeroALetras = numeroALetras($venta->precio_venta_final); 
        $areaEnLetras = numeroALetras($venta->lote->area);
    
        // Obtener el proyecto relacionado a partir de la sesión
        $proyectoId = session('proyecto_id');
        $proyecto = Proyecto::find($proyectoId);
    
        // Verificar si el proyecto fue encontrado
        if (!$proyecto) {
            dd("Proyecto no encontrado con el id: " . $proyectoId);
        }
    
        // Obtener los lotes relacionados con la venta
        // Obtener las manzanas si es necesario
        $manzanas = Manzana::all();  // Puedes ajustar esto según lo que necesites mostrar de las manzanas
    
        // Cargar la vista de la carta finiquito con los datos
        $view = view('carta_finiquito_contado', compact('venta', 'contacto', 'numeroALetras', 'proyecto', 'areaEnLetras'))->render();
    
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        
        // Crear una instancia de Dompdf
        $dompdf = new Dompdf($options);
        
        // Cargar el contenido HTML
        $dompdf->loadHtml($view);
        
          // Configurar tamaño carta (8.5 x 11 pulgadas)
          $dompdf->setPaper([0, 0, 612, 792], 'portrait'); // 8.5 x 11 pulgadas en puntos (612 x 792)

        
        // Renderizar el PDF (esto genera el archivo PDF)
        $dompdf->render();
        
        // Descargar el PDF generado
        return $dompdf->stream('carta_finiquito.pdf', ['Attachment' => 0]); // El 0 significa que se abrirá en el navegador en lugar de descargarlo automáticamente
    }
    public function generarAut($id)
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
        $numeroALetras = NumeroALetras($venta->precio_venta_final);
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
        $html = view('automatico', compact('venta', 'fechaActual', 'numeroALetras', 'contacto', 'proyecto'))->render();
    
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
