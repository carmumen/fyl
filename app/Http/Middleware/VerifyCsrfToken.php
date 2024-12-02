<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
         '/pagomedios',
    ];

    protected function handleException($request, $exception)
    {

        if ($exception instanceof TokenMismatchException) {
            // Redirigir al usuario al formulario de inicio de sesión
            return redirect()->route('login')->with('message', 'La sesión ha expirado. Por favor, inicia sesión nuevamente.');
        } elseif ($exception instanceof AuthenticationException) {
            // Redirigir al formulario de inicio de sesión u otra acción de autenticación
            return redirect()->route('login');
        }


        throw $exception;
    }
    
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        return redirect()->route('login')->with('message', 'La sesión ha expirado. Por favor, inicia sesión nuevamente.');
    }
    
    
    
}
