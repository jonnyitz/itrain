<?php

namespace App\Http\Controllers;

use App\Models\Proyecto; // Asegúrate de que el modelo Proyecto está importado
use Illuminate\Http\Request;

class InicioController extends Controller
{
    // Método index para mostrar un proyecto específico o todos los proyectos
    public function index($id = null)
    {
        // Obtener todos los proyectos
        $proyectos = Proyecto::all();

        if ($id) {
            // Buscar el proyecto por su ID si se proporciona un ID
            $proyecto = Proyecto::findOrFail($id);

            // Guardar el ID del proyecto en la sesión
            session(['proyecto_id' => $id]);

            // Pasar el proyecto a la vista
            return view('inicio', compact('proyecto', 'proyectos'));
        } else {
            // Si no se selecciona un proyecto, verificar si hay un proyecto en la sesión
            if (session('proyecto_id')) {
                $proyecto = Proyecto::findOrFail(session('proyecto_id'));
                return view('inicio', compact('proyecto', 'proyectos'));
            } else {
                // Si no hay un proyecto seleccionado en la sesión, solo mostrar los proyectos disponibles
                return view('inicio', compact('proyectos'));
            }
        }
    }
}
