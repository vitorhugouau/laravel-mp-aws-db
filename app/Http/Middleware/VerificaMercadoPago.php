<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificaMercadoPago
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header('x-mercadopago-signature');
        $expectedSignature = env('MERCADOPAGO_SIGNATURE');

        if (!$signature || $signature !== $expectedSignature) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        return $next($request);
    }
}
