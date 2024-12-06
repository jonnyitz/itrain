<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ContactoController extends Controller
{
    // Mostrar lista de contactos
    public function index()
    {
        $contactos = Contacto::all();
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

        Contacto::create($request->all());

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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'curp_rfc' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'observacion' => 'nullable|string',
        ]);

        $contacto = Contacto::findOrFail($id);
        $contacto->update($request->all());

        return redirect()->route('contactos')->with('success', 'Contacto actualizado exitosamente.');
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
        // Obtener los datos de contacto (puedes usar cualquier consulta que necesites)
        $contactos = Contacto::all();

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
