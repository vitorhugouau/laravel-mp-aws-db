<?php

// app/Http/Middleware/VerifyCsrfToken.php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * O conjunto de exceções para a verificação CSRF.
     *
     * @var array
     */
    protected $except = [
        'webhook', 
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Se a requisição for do tipo POST, PUT, PATCH ou DELETE, o Laravel verifica o CSRF automaticamente
        // Você pode adicionar outras lógicas personalizadas, se necessário

        return parent::handle($request, $next);
    }
}
