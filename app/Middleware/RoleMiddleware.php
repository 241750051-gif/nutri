<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->activo) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Su cuenta se encuentra desactivada.']);
        }

        if ($user->rol !== $role) {
            return abort(403, 'Acceso denegado a esta seccion.');
        }

        return $next($request);
    }
}