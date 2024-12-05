<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('/');
        }

        // Obtén el rol del usuario desde la relación
        $user = Auth::user();
        $userRole = $user->rol->role ?? null; // Asegúrate de que 'rol' es la relación correcta

        // Verifica si el rol del usuario está en la lista de roles permitidos
        foreach ($roles as $role) {
            if (trim($role) === $userRole) { // Compara los roles después de eliminar los espacios adicionales
                return $next($request); // Continúa con la solicitud
            }
        }

        // Si el rol del usuario no está en la lista de roles permitidos, redirige con un mensaje de error
        return redirect('/inicio')->with('error', 'Error de permisos - no tienes los permisos para acceder');
    }
}