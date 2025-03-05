<?php

namespace App\Http\Controllers;

use App\Models\Proyecto; // Asegúrate de que el modelo Proyecto está importado
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all(); // Obtener todos los proyectos
        return view('proyectos', compact('proyectos')); // Pasar proyectos a la vista
    }
    // Otros métodos (create, store, edit, update, destroy) aquí...
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'total_lotes' => 'required|integer',
            'lotes_disponibles' => 'required|integer',
            'estado' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
            'moneda' => 'required|string|max:255',
            'propietario' => 'required|string|max:255', // Nueva validación para propietario
            'parcela' => 'required|string|max:255', // Nueva validación para parcela    
        ]);
    
        $proyecto = new Proyecto();
        $proyecto->nombre = $request->nombre;
        $proyecto->ubicacion = $request->ubicacion;
        $proyecto->total_lotes = $request->total_lotes;
        $proyecto->lotes_disponibles = $request->lotes_disponibles;
        $proyecto->estado = $request->estado;
        $proyecto->moneda = $request->moneda;
        $proyecto->propietario = $request->propietario; // Guardar propietario
        $proyecto->parcela = $request->parcela; // Guardar parcela
    
        $proyecto = new Proyecto($request->all());

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName(); // Nombre único
            $rutaImagen = 'imagenes/' . $nombreImagen;
            
            $imagen->move(public_path('imagenes'), $nombreImagen); // Guarda en public/imagenes
            
            $proyecto->imagen = $rutaImagen; // Guarda la ruta en la BD
        }
        
        $proyecto->save();
    
        return redirect()->back()->with('success', 'Proyecto creado exitosamente.');
    }
    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id); // Encuentra el proyecto por su ID
        return view('proyectos_edit', compact('proyecto'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required',
            'ubicacion' => 'required',
            'moneda' => 'required',
            'total_lotes' => 'required|numeric',
            'lotes_disponibles' => 'required|numeric',
            'estado' => 'required',
            'imagen' => 'nullable|image',
            'propietario' => 'required|string|max:255', // Nueva validación para propietario
            'parcela' => 'required|string|max:255', // Nueva validación para parcela    
        ]);

        $proyecto = Proyecto::findOrFail($id); // Encuentra el proyecto que se desea editar

        // Actualiza los datos del proyecto
        $proyecto->nombre = $request->nombre;
        $proyecto->ubicacion = $request->ubicacion;
        $proyecto->moneda = $request->moneda;
        $proyecto->total_lotes = $request->total_lotes;
        $proyecto->lotes_disponibles = $request->lotes_disponibles;
        $proyecto->estado = $request->estado;
        $proyecto->propietario = $request->propietario; // Guardar propietario
        $proyecto->parcela = $request->parcela; // Guardar parcela

        $proyecto = new Proyecto($request->all());

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName(); // Nombre único
            $rutaImagen = 'imagenes/' . $nombreImagen;
            
            $imagen->move(public_path('imagenes'), $nombreImagen); // Guarda en public/imagenes
            
            $proyecto->imagen = $rutaImagen; // Guarda la ruta en la BD
        }
        
        $proyecto->save();
        return redirect()->route('inicio')->with('success', 'Proyecto actualizado exitosamente.');
    }

        public function filtrar(Request $request)
    {
        $filtro = $request->input('filtro');

        $proyectos = Proyecto::where('nombre', 'like', "%$filtro%")
                            ->orWhere('ubicacion', 'like', "%$filtro%")
                            ->get();

        return view('proyectos', compact('proyectos'));
    }
     // Método para seleccionar un proyecto
     public function seleccionarProyecto($id)
     {
         // Verifica si ya se ha seleccionado un proyecto
         if (!session()->has('proyecto_id') || session('proyecto_id') != $id) {
             session(['proyecto_id' => $id]); // Establecer el proyecto seleccionado
         }
     
         // Redirige a la página de proyectos si el proyecto ya está en la sesión
         return redirect()->route('inicio');
     }
     

 

    
}
