<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RememberUser
{
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario no está autenticado y existe una cookie 'remember_token'
        if (!Auth::check() && $request->hasCookie('remember_token')) {
            // Buscar el usuario con el token de la cookie
            $user = User::where('remember_token', $request->cookie('remember_token'))->first();

            // Si el usuario existe, lo logueamos
            if ($user) {
                Auth::login($user); // Logueamos al usuario manualmente
            }
        }

        return $next($request); // Continuamos con la solicitud
    }
}
