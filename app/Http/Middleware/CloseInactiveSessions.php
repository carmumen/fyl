<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CloseInactiveSessions
{
    public function handle($request, Closure $next)
    {
        // Define el tiempo de inactividad (en minutos)
        $inactivityTime = 10;

        if (Auth::check()) {
            $lastActivity = Session::get('lastActivityTime');

            if (!$lastActivity) {
                Session::put('lastActivityTime', now());
            } else {
                if (now()->diffInMinutes($lastActivity) > $inactivityTime) {
                    Auth::logout();
                    Session::flush();
                    DB::disconnect(); // Cierra la conexiÃ³n actual
                    return redirect('/login')->withErrors(['message' => 'Tu sesi¨®n ha expirado por inactividad.']);
                }
            }

            Session::put('lastActivityTime', now());
        }

        return $next($request);
    }
}
