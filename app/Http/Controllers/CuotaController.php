<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\Contacto;
use App\Models\Lote;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Banco;
use App\Models\Venta;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Carbon;

class CuotaController extends Controller
{
    public function index()
    {
        $proyectoId = session('proyecto_id');  // Asegúrate de que esta variable esté definida

        $cuotas = Cuota::with(['contacto', 'lote'])
        ->where('proyecto_id', $proyectoId) // Filtrar por proyecto_id
        ->get();
        $contactos = Contacto::all(); // Asumiendo que tienes un modelo `Contacto`
        $lotes = Lote::all(); // Asumiendo que tienes un modelo `Lote`
        $bancos = Banco::all();
    
        // Aquí obtienes la venta (suponiendo que puedes obtener la venta de alguna manera, por ejemplo, por el ID o la sesión)
        $venta = Venta::first(); // Esto es solo un ejemplo, ajusta a tu lógica
    
        return view('cuotas', compact('cuotas', 'contactos', 'lotes', 'bancos', 'venta'));
    }
    public function edit($id)
    {
        // Obtener la cuota con el ID especificado
        $cuota = Cuota::findOrFail($id);
        
        // Obtener datos relacionados, como contactos y bancos
        $contactos = Contacto::all();
        $bancos = Banco::all();
    
        // Pasar los datos a la vista
        return view('cuotas_edit', compact('cuota', 'contactos', 'bancos'));
    }
        public function store(Request $request)
    {
        $request->validate([
            'contacto_id' => 'required',

            'comprobante' => 'required',
            'n_cts' => 'required',
            'tipo' => 'required',
            'fecha' => 'required|date',
            'voucher' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validación para imágenes
            'banco_id' => 'nullable|exists:bancos,id',
            'forma_de_pago' => 'required|string|max:255',  // Nueva validación
            'concep' => 'nullable|string|max:255',  // Validación para 'concep'
            'cuotas' => 'nullable|numeric',  // Validación para 'cuotas'
            'monto' => 'required|numeric', // Validación para monto

        

        ]);
        // Manejo de la imagen
        $voucherPath = null;
        if ($request->hasFile('voucher')) {
            // Eliminar imagen anterior si existe
            if ($request->voucher && file_exists(public_path('images/' . $request->voucher))) {
                unlink(public_path('images/' . $request->voucher));
            }

            // Obtener el nombre del archivo
            $fileName = uniqid() . '.' . $request->file('voucher')->extension();

            // Mover la imagen a la carpeta public/images
            $request->file('voucher')->move(public_path('images'), $fileName);

            // Asignar el nombre del archivo a la variable
            $voucherPath = 'images/' . $fileName;
        }


        $cuotas = $request->all();
        $cuotas['proyecto_id'] = session('proyecto_id');  // Añadir el proyecto_id
        Cuota::create($cuotas);

        // Crear la nueva cuota con los datos recibidos
        Cuota::create([
            'contacto_id' => $request->contacto_id,
            'comprobante' => $request->comprobante,
            'n_cts' => $request->n_cts,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
            'rd' => $request->rd,
            'voucher' => $voucherPath,  // Guarda la ruta del archivo
            'banco_id' => $request->banco_id,
            'forma_de_pago' => $request->forma_de_pago,
            'concep' => $request->concep,  // Almacenar el valor de 'concep'
            'cuotas' => $request->cuotas,  // Almacenar el valor de 'cuotas'
            'monto' => $request->monto, // Guardar el monto

        ]);
        return redirect()->route('inicio')->with('success', 'Cuota creada exitosamente.');
        }
        public function update(Request $request, $id)
        {
            // Validación de los campos
            $request->validate([
                'contacto_id' => 'required',
                'comprobante' => 'required',
                'n_cts' => 'required',
                'tipo' => 'required',
                'fecha' => 'required|date',
                'voucher' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banco_id' => 'nullable|exists:bancos,id',
                'forma_de_pago' => 'required|string|max:255',
                'concep' => 'nullable|string|max:255',
                'cuotas' => 'nullable|numeric',
                'monto' => 'required|numeric',
            ]);

            // Obtener la cuota que se va a actualizar
            $cuota = Cuota::findOrFail($id);

            // Manejo del archivo voucher (si existe uno nuevo)
            $voucherPath = $cuota->voucher; // Mantener la ruta del archivo existente
            if ($request->hasFile('voucher')) {
                // Eliminar el archivo viejo si existe
                if (file_exists(public_path($cuota->voucher))) {
                    unlink(public_path($cuota->voucher));
                }

                // Subir la nueva imagen
                $fileName = uniqid() . '.' . $request->file('voucher')->extension();
                $request->file('voucher')->move(public_path('images'), $fileName);
                $voucherPath = 'images/' . $fileName;
            }

            // Actualizar la cuota
            $cuota->update([
                'contacto_id' => $request->contacto_id,
                'comprobante' => $request->comprobante,
                'n_cts' => $request->n_cts,
                'tipo' => $request->tipo,
                'fecha' => $request->fecha,
                'voucher' => $voucherPath,
                'banco_id' => $request->banco_id,
                'forma_de_pago' => $request->forma_de_pago,
                'concep' => $request->concep,
                'cuotas' => $request->cuotas,
                'monto' => $request->monto,
            ]);

            return redirect()->route('inicio')->with('success', 'Cuota actualizada exitosamente.');
        }

        public function buscarContacto(Request $request)
        {
            $query = $request->input('q');
        
            if (!$query) {
                return response()->json([], 200);  // Si no hay término de búsqueda, devolver una respuesta vacía
            }
        
            $contactos = Contacto::where('nombre', 'LIKE', "%$query%")
                ->orWhere('apellidos', 'LIKE', "%$query%")
                ->with(['ventas.lote.manzana' => function ($query) {
                    // Incluir la relación de manzana en el lote
                    $query->select('id', 'nombre');  // Aquí "nombre" es el campo de la manzana
                }])
                ->get();
        
            return response()->json($contactos, 200);  // Devuelve los contactos con las ventas y manzanas
        }
        public function generarPDF($id)
        {
            function convertirNumeroALetras($numero)
            {
                $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
                $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
                $centenas = ['', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
    
                if ($numero == 0) {
                    return 'cero';
                }
    
                $letras = '';
    
                // Manejar números mayores de 1000
                if ($numero >= 1000) {
                    $miles = intval($numero / 1000);
                    $letras .= $miles == 1 ? 'mil' : $unidades[$miles] . ' mil ';
                    $numero %= 1000;
                }
    
                // Manejar centenas
                if ($numero >= 100) {
                    $cien = intval($numero / 100);
                    $letras .= $centenas[$cien] . ' ';
                    $numero %= 100;
                }
    
                // Manejar decenas
                if ($numero >= 20) {
                    $diez = intval($numero / 10);
                    $letras .= $decenas[$diez] . ' ';
                    $numero %= 10;
                } elseif ($numero >= 10) {
                    // Manejar números entre 10 y 19
                    $especiales = [
                        10 => 'diez', 11 => 'once', 12 => 'doce', 13 => 'trece', 14 => 'catorce',
                        15 => 'quince', 16 => 'dieciséis', 17 => 'diecisiete', 18 => 'dieciocho', 19 => 'diecinueve',
                    ];
                    return $letras . $especiales[$numero];
                }
    
                // Manejar unidades
                if ($numero > 0) {
                    $letras .= $unidades[$numero];
                }
    
                return trim($letras);
            }
            
            // Obtén la cuota seleccionada
            $cuota = Cuota::findOrFail($id); // Obtiene la cuota por ID
            $fechaActual = Carbon::now()->format('d-m-Y'); // Fecha actual usando Carbon
                // Llamar a la función convertirNumeroALetras
            $numeroALetras = convertirNumeroALetras($cuota->monto);
            $contacto = $cuota->contacto;
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
        
            // Carga la vista en HTML (pasando solo la cuota seleccionada)
            $html = view('cuotas_pdf', compact('cuota', 'fechaActual', 'numeroALetras','contacto','proyecto'))->render();
        
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
            return $dompdf->stream('cuota_' . $id . '_' . $fechaActual . '.pdf');
        }
        public function generarCobro($id)
        {
            function convertirNumeroALetras($numero)
            {
                $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
                $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
                $centenas = ['', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
    
                if ($numero == 0) {
                    return 'cero';
                }
    
                $letras = '';
    
                // Manejar números mayores de 1000
                if ($numero >= 1000) {
                    $miles = intval($numero / 1000);
                    $letras .= $miles == 1 ? 'mil' : $unidades[$miles] . ' mil ';
                    $numero %= 1000;
                }
    
                // Manejar centenas
                if ($numero >= 100) {
                    $cien = intval($numero / 100);
                    $letras .= $centenas[$cien] . ' ';
                    $numero %= 100;
                }
    
                // Manejar decenas
                if ($numero >= 20) {
                    $diez = intval($numero / 10);
                    $letras .= $decenas[$diez] . ' ';
                    $numero %= 10;
                } elseif ($numero >= 10) {
                    // Manejar números entre 10 y 19
                    $especiales = [
                        10 => 'diez', 11 => 'once', 12 => 'doce', 13 => 'trece', 14 => 'catorce',
                        15 => 'quince', 16 => 'dieciséis', 17 => 'diecisiete', 18 => 'dieciocho', 19 => 'diecinueve',
                    ];
                    return $letras . $especiales[$numero];
                }
    
                // Manejar unidades
                if ($numero > 0) {
                    $letras .= $unidades[$numero];
                }
    
                return trim($letras);
            }
            
            // Obtén la cuota seleccionada
            $cuota = Cuota::findOrFail($id); // Obtiene la cuota por ID
            $fechaActual = Carbon::now()->format('d-m-Y'); // Fecha actual usando Carbon
                // Llamar a la función convertirNumeroALetras
            $numeroALetras = convertirNumeroALetras($cuota->venta_precio_final);
            $contacto = $cuota->contacto;
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
        
            // Carga la vista en HTML (pasando solo la cuota seleccionada)
            $html = view('cobros', compact('cuota', 'fechaActual', 'numeroALetras','contacto','proyecto'))->render();
        
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
            return $dompdf->stream('cuota_' . $id . '_' . $fechaActual . '.pdf');
        }
        
        public function generarEstadoDeCuenta(Request $request, $venta_id)
        {
            // Obtener la venta y sus cuotas asociadas
            $venta = Venta::findOrFail($venta_id);
            $cuotas = Cuota::where('contacto_id', $venta->contacto_id)->get();
            $proyectoId = session('proyecto_id');
            // Intentar obtener el proyecto con ese id
            $proyecto = Proyecto::find($proyectoId);

            // Verificar si el proyecto fue encontrado
            if (!$proyecto) {
                dd("Proyecto no encontrado con el id: " . $proyectoId);
            }
            // Renderizar la vista con los datos de la venta y las cuotas
            $html = view('estado_de_cuenta', compact('venta', 'cuotas','proyecto'))->render();
           
            // Configuración de Dompdf
            $options = new Options();
            $options->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper([0, 0, 612, 792], 'portrait'); // 8.5 x 11 pulgadas en puntos (612 x 792)
            $dompdf->render();
        
            // Descargar el PDF generado
            return $dompdf->stream('estado_de_cuenta_actualizado.pdf');
        }
        
        
}