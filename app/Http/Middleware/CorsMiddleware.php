<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CorsMiddleware
{
 /**
     * Dominios permitidos para acceder a la API
     */
    private array $allowedOrigins = [
        'https://www.corposurgir21.org',
        'https://corposurgir21.org',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Permitir localhost en desarrollo
        if (env('APP_ENV') === 'local' || env('APP_ENV') === 'development') {
            $this->allowedOrigins[] = 'http://localhost:3000';
            $this->allowedOrigins[] = 'http://localhost:8080';
            $this->allowedOrigins[] = 'http://localhost:5173';
            $this->allowedOrigins[] = 'http://127.0.0.1:3000';
            $this->allowedOrigins[] = 'http://127.0.0.1:8080';
            $this->allowedOrigins[] = 'http://127.0.0.1:5173';
        }

        $origin = $request->header('Origin');
        
        // Verificar si el origen está permitido
        $allowedOrigin = in_array($origin, $this->allowedOrigins) ? $origin : null;

        // Si no hay origen permitido y no es local, usar el primero como fallback
        if (!$allowedOrigin && (env('APP_ENV') === 'local' || env('APP_ENV') === 'development')) {
            $allowedOrigin = $origin ?: '*';
        }

        // Manejar preflight OPTIONS request ANTES de continuar
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', $allowedOrigin ?: '')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin, X-CSRF-Token')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '86400');
        }

        // Continuar con la petición normal
        $response = $next($request);

        // Aplicar headers CORS a la respuesta
        if ($allowedOrigin) {
            $response->header('Access-Control-Allow-Origin', $allowedOrigin);
        }
        
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin, X-CSRF-Token');
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Max-Age', '86400');

        return $response;
    }
}