<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

       // Intentar encontrar el usuario por el email
       $user = User::where('email', $request->email)->first();

       // Verificar si el usuario existe y si está activado (activo == 1)
       if ($user && $user->activo == 0) {
           // Si el usuario está desactivado, no permitir el inicio de sesión
           return back()->withErrors(['email' => 'Tu usuario ha sido desactivado. Comunícate con el proveedor.'])->onlyInput('email');
       }

        // Intentar autenticar al usuario con la funcionalidad "Recuérdame"
        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->has('remember') // Verificar si el usuario marcó "Recuérdame"
        )) {
            
            // Redirigir a la vista de inicio
            return redirect()->route('proyectos');  // Cambia 'inicio' por la ruta que deseas
        }

        return back()->withErrors(['email' => 'Las credenciales no son correctas'])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada');
    }
    
}
