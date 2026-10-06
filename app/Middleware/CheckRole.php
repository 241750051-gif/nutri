<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja las peticiones entrantes y verifica el rol del usuario.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica si el usuario está autenticado y si su rol coincide
        if (!$request->user() || $request->user()->rol !== $role) {
            // Si el campo en tu base de datos es 'role' en vez de 'rol', ajusta la propiedad arriba
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}