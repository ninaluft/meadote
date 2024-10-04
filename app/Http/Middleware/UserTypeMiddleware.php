<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
{
    public function handle(Request $request, Closure $next, $type)
    {
        // Verifica se o usuário está autenticado e se é do tipo especificado
        if (Auth::check() && Auth::user()->user_type === $type) {
            return $next($request);
        }

        // Caso contrário, retorna erro de autorização
        return abort(403, 'Unauthorized');
    }
}
