<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlternativeLoginController extends Controller
{
    // Mostrar el formulario de inicio de sesión alternativo
    public function showLoginForm()
    {
        return view('fyl/life/index');
        return view('auth.alternative.login');
    }

    // Procesar el inicio de sesión alternativo
    public function login(Request $request)
    {
        // Validar las credenciales del usuario
        $credentials = $request->only('email', 'password');

        // Realizar la autenticación utilizando la tabla de usuarios alternativa
        if (Auth::guard('alternative')->attempt($credentials)) {
            // La autenticación fue exitosa
            // Redirigir al usuario a su área protegida o a la página deseada
            return redirect()->intended('/dashboard');
        } else {
            // La autenticación falló
            // Redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
            return redirect()->back()->withInput()->withErrors(['email' => 'Credenciales incorrectas']);
        }
    }

    // Cerrar sesión para usuarios alternativos
    public function logout(Request $request)
    {
        Auth::guard('alternative')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de inicio o a donde desees después de cerrar sesión
        return redirect('/');
    }
}

