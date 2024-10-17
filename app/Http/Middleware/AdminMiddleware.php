<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Verificar se o usuário está autenticado e se é um administrador
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Se não for um administrador, redireciona para uma página de erro ou login
        return redirect()->route('admin.login');
    }
}

