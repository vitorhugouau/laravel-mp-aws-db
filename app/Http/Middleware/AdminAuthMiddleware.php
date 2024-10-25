<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('AdminAuthMiddleware')->check()) {
            return $next($request);
        }
        
        return redirect('adm');
    }
}