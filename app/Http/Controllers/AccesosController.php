<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Grupo;
use Illuminate\Http\Request;

class AccesosController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        $grupos = Grupo::all();

        // Depuración
      

        return view('accesos', compact('empresas', 'grupos'));
    }

}

