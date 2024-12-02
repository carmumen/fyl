<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseController extends Controller
{
    // Método para ejecutar el script PHP
    public function killConnections()
    {
        // Ruta al archivo PHP que matará las conexiones
        $scriptPath = base_path('public/kill_processes.php');
        
        // Verificar si el archivo existe
        if (file_exists($scriptPath)) {
            // Ejecutar el script PHP
            exec("php $scriptPath");

            //return redirect()->back()->with('status', 'Conexiones activas han sido cerradas.');
        } else {
            return redirect()->back()->with('error', 'El archivo de script no existe.');
        }
    }
}
