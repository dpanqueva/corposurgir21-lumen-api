<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Manejar preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return $this->setCorsHeaders(response()->json(['method' => 'OPTIONS'], 200));
        }

        // Continuar con la request normal y añadir headers CORS
        $response = $next($request);
        
        return $this->setCorsHeaders($response);
    }

    /**
     * Set CORS headers on response
     *
     * @param  mixed  $response
     * @return mixed
     */
    protected function setCorsHeaders($response)
    {
        $response->header('Access-Control-Allow-Origin', '*')
                 ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                 ->header('Access-Control-Allow-Credentials', 'true')
                 ->header('Access-Control-Max-Age', '86400')
                 ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        
        return $response;
    }
}