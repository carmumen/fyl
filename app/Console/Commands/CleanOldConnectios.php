<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanOldConnections extends Command
{
    protected $signature = 'connections:clean';

    public function handle()
    {
        // Eliminar registros inactivos por más de 30 minutos
        DB::table('connection_log')
            ->where('last_activity', '<', now()->subMinutes(30))
            ->delete();
    }
}