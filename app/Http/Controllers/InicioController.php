<?php

// app/Http/Controllers/InicioController.php
namespace App\Http\Controllers;

use App\Models\Proyecto; // Asegúrate de que el modelo Proyecto está importado
use Illuminate\Http\Request;

class InicioController extends Controller
{
    // Método index para mostrar un proyecto específico o todos los proyectos
    public function index($id = null)
    {
        $proyectos = Proyecto::all(); // Obtener todos los proyectos

        if ($id) {
            // Buscar el proyecto por su ID si se proporciona un ID
            $proyecto = Proyecto::findOrFail($id);

            // Guardar el ID del proyecto en la sesión
            session(['proyecto_id' => $id]);

            // Pasar el proyecto a la vista
            return view('inicio', compact('proyecto', 'proyectos'));
        } else {
            // Pasar la variable $proyectos a la vista
            return view('inicio', compact('proyectos'));
        }
    }
}
