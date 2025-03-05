<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProyectoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el proyecto está en la sesión
        if (!session()->has('proyecto_id')) {
            // Si no hay un proyecto en la sesión, establecer uno por defecto
            $proyecto = \App\Models\Proyecto::first(); // O tu lógica de selección
            session(['proyecto_id' => $proyecto->id]);
        }
    
        return $next($request);
    }
    
}
