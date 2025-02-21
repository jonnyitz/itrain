<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ContactoController extends Controller
{
    // Mostrar lista de contactos
    public function index(Request $request)
{
    // Obtén el término de búsqueda y el ID del proyecto de la solicitud
    $searchTerm = $request->input('search');
    $proyectoId = session('proyecto_id'); // O también puedes obtenerlo de la solicitud si lo prefieres: $request->input('proyecto_id')

    // Realiza la consulta para filtrar los contactos
    $contactos = Contacto::when($searchTerm, function ($query, $searchTerm) {
        return $query->where('nombre', 'like', "%{$searchTerm}%")
                     ->orWhere('curp_rfc', 'like', "%{$searchTerm}%")
                     ->orWhere('telefono', 'like', "%{$searchTerm}%");
    })
    ->where('proyecto_id', $proyectoId) // Filtrar por proyecto
    ->paginate(10);

    return view('contactos', compact('contactos'));
}

    // Guardar nuevo contacto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'curp_rfc' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'observacion' => 'nullable|string',
        ]);

        // Asume que el contacto también debe tener un proyecto_id asociado
        $contacto = $request->all();
        $contacto['proyecto_id'] = session('proyecto_id');  // Añadir el proyecto_id
        Contacto::create($contacto);

        return redirect()->route('inicio')->with('success', 'Contacto creado exitosamente.');
    }

    // Cargar los datos de contacto para edición (AJAX)
    public function edit($id)
    {
        $contacto = Contacto::findOrFail($id);
        return response()->json($contacto);
    }

    // Actualizar contacto existente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'curp_rfc' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'observacion' => 'nullable|string',
        ]);

        // Luego, realizas la actualización del contacto
        $contacto = Contacto::find($id);
        $contacto->update($validated);

        return response()->json(['message' => 'Contacto actualizado con éxito']);
    }
    
    // Eliminar contacto
    public function destroy($id)
    {
        $contacto = Contacto::findOrFail($id);
        $contacto->delete();

        return redirect()->route('inicio')->with('success', 'Contacto eliminado exitosamente.');
    }
    
    // Método para exportar a Excel
    public function exportToExcel()
    {
        // Obtener el proyecto_id de la sesión
        $proyecto_id = session('proyecto_id');

        // Obtener los contactos del proyecto
        $contactos = Contacto::where('proyecto_id', $proyecto_id)->get();

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer las cabeceras
        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Apellidos');
        $sheet->setCellValue('C1', 'CURP/RFC');
        $sheet->setCellValue('D1', 'Teléfono');
        $sheet->setCellValue('E1', 'Dirección');
        $sheet->setCellValue('F1', 'Observación');

        // Llenar los datos de los contactos
        $row = 2; // Comienza desde la fila 2 (debido a las cabeceras)
        foreach ($contactos as $contacto) {
            $sheet->setCellValue('A' . $row, $contacto->nombre);
            $sheet->setCellValue('B' . $row, $contacto->apellidos);
            $sheet->setCellValue('C' . $row, $contacto->curp_rfc);
            $sheet->setCellValue('D' . $row, $contacto->telefono);
            $sheet->setCellValue('E' . $row, $contacto->direccion);
            $sheet->setCellValue('F' . $row, $contacto->observacion);
            $row++;
        }

        // Crear un escritor para guardar el archivo Excel
        $writer = new Xlsx($spreadsheet);

        // Definir el nombre del archivo
        $fileName = 'contactos.xlsx';

        // Forzar la descarga del archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Guardar el archivo Excel directamente en la salida para la descarga
        $writer->save('php://output');
    }
}
