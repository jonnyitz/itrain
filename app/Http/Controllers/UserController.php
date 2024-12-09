<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Grupo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios con sus relaciones (empresa y grupo)
        $usuarios = User::with(['empresa', 'grupo'])->get();

        // Obtener todas las empresas y grupos para llenar los selectores en el formulario
        $empresas = Empresa::all();
        $grupos = Grupo::all();

        return view('users', compact('usuarios', 'empresas', 'grupos'));
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'empresa_id' => 'required|exists:empresas,id',
        'grupo_id' => 'required|exists:grupos,id',
        'password' => 'required|string|min:8',
        
    ]);

    User::create($request->all());

    return redirect()->route('users')->with('success', 'Usuario creado con éxito');
}


    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'empresa_id' => 'required|exists:empresas,id',
            'grupo_id' => 'required|exists:grupos,id',
            'password' => 'required|string|min:8',
             
        ]);

        // Buscar el usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualizar los datos del usuario
        $usuario->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('users')->with('success', 'Usuario actualizado');
    }

    public function destroy($id)
    {
        // Buscar el usuario por su ID
        $usuario = User::findOrFail($id);

        // Eliminar el usuario
        $usuario->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Usuario eliminado');
    }
    public function toggleActive(User $user)
    {
        $user->activo = !$user->activo;
        $user->save();

        $message = $user->activo ? 'Usuario activado con éxito' : 'Usuario desactivado con éxito';
        return redirect()->route('inicio')->with('success', $message);
    }
}
