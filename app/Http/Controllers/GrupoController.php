<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Empresa;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with('empresa')->get();
        return view('grupos', ['grupos' => $grupos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'empresa' => 'required|string|max:255'
        ]);

        $empresa = Empresa::firstOrCreate(['nombre' => $request->empresa]);

        Grupo::create([
            'descripcion' => $request->descripcion,
            'empresa_id' => $empresa->id
        ]);

        return redirect()->back()->with('success', 'Grupo creado con éxito.');
    }
    public function export()
    {
        $grupos = Grupo::with('empresa')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Descripción del Grupo');
        $sheet->setCellValue('B1', 'Empresa Inmobiliaria');

        // Datos
        foreach ($grupos as $index => $grupo) {
            $sheet->setCellValue('A' . ($index + 2), $grupo->descripcion);
            $sheet->setCellValue('B' . ($index + 2), $grupo->empresa->nombre);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'grupos.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
