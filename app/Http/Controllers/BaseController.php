<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class BaseController extends Controller
{
    public function __construct()
    {
        // Comprobar si el proyecto está en la sesión y si no lo está, establecer uno por defecto
        if (!session()->has('proyecto_id')) {
            // Establecer el proyecto en la sesión (puedes hacer lo que necesites aquí)
            $proyecto = Proyecto::first(); // Aquí puedes agregar la lógica que necesites
            session(['proyecto_id' => $proyecto->id]);
        }
    }
}
