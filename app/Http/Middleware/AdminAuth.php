<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('AuthAdmin')->check()) {
            return $next($request);

        }

        return redirect('adm');
    }
}