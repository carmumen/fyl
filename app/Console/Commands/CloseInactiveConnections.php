<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB; // Asegúrate de incluir esto

class CloseInactiveConnections extends Command
{
    protected $signature = 'db:close-inactive-connections';
    protected $description = 'Cierra las conexiones inactivas en la base de datos';

    public function handle()
    {
        try {
            $processes = DB::select("SHOW PROCESSLIST");

            foreach ($processes as $process) {
                // Considera inactiva una conexión que ha estado abierta más de 10 segundos
                if ($process->Time > 10 && empty($process->State)) {
                    $processId = $process->Id;
                    $this->info("Cerrando conexión ID: $processId");
                    DB::statement("KILL $processId");
                }
            }
            $this->info("Conexiones inactivas cerradas correctamente.");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
