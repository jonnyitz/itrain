<?php

namespace App\Http\Controllers;

use App\Models\Contacto; // Modelo de la base de datos
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteClientesController extends Controller
{
    public function index()
    {
        return view('r_clientes'); // Asegúrate de que la vista tenga este nombre
    }
    public function generarPDF()
    {
        // Obtenemos los contactos desde la base de datos
        $contactos = Contacto::all();

        // Cargamos la vista para generar el PDF
        $pdf = PDF::loadView('listas_clientes', compact('contactos'));

        // Retornamos la vista previa del PDF en el navegador
        return $pdf->stream('lista_clientes.pdf');
    }
}
