<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogPostRequest
{
    public function handle(Request $request, Closure $next)
    {
        // Capturar y registrar datos de la solicitud POST
        if ($request->isMethod('post')) {
            $requestData = $request->all(); // Obtener todos los datos de la solicitud POST
            Log::info('POST Request Captured:', $requestData);
        }

        return $next($request);
    }
}
