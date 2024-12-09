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
        // Verificar que el valor de 'role' se está enviando
    
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:255',
            'empresa_id' => 'required|exists:empresas,id',
            'password' => 'required|string|min:8',
        ]);
    
        // Crear el nuevo usuario
        User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'role' => $request->role,
            'empresa_id' => $request->empresa_id,
            'password' => bcrypt($request->password),
        ]);
    
        return redirect()->route('inicio')->with('success', 'Usuario creado con éxito');
    }
    


    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'empresa_id' => 'required|exists:empresas,id',
            'password' => 'required|string|min:8',
            'role'=>'required|string|max:255',
             
        ]);

        // Buscar el usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualizar los datos del usuario, incluyendo el campo 'role'
        $usuario->update([
        'name' => $request->name,
        'apellidos' => $request->apellidos,
        'email' => $request->email,
        'empresa_id' => $request->empresa_id,
        'role' => $request->role,      // Actualizar el campo 'role'
        'password' => bcrypt($request->password),  // Asegurarse de que la contraseña esté cifrada
    ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('inicio')->with('success', 'Usuario actualizado');
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
