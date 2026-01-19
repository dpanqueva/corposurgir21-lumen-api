<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Headers de seguridad básicos
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // HSTS solo en producción con HTTPS
        if (env('APP_ENV') === 'production' && $request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        // Content Security Policy ajustado para APIs
        // Permitimos conexiones desde los dominios autorizados
        $csp = "default-src 'self'; " .
               "connect-src 'self' https://www.corposurgir21.org https://corposurgir21.org; " .
               "script-src 'self'; " .
               "style-src 'self' 'unsafe-inline'; " .
               "img-src 'self' data: https:; " .
               "font-src 'self' data:; " .
               "frame-ancestors 'self';";
        
        $response->headers->set('Content-Security-Policy', $csp);
        
        // Eliminar headers que revelan información del servidor
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }

}