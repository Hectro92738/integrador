<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {

        if (Auth::check()) {

            $userRole = Auth::user()->rol->role ?? null;
            
            if ($userRole === $role) {
                return $next($request);
            }
        }

        return redirect('/inicio')->with('error', 'Error - No tienes los permisos para acceder');
    }
}