<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Fyl\Staff;

class ListasController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['lifeEnroller']]);
    }

    public function training()
    {
        try {
            $training = DB::table('fyl_training as T')
                ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) AS name"))
                ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
                ->join('fyl_campus_user as CU', 'C.id', '=', 'CU.campus_id')
                ->join(DB::raw("(SELECT campus_id, MIN(start_date_focus) as start_date_focus
                        FROM fyl_training
                        WHERE start_date_focus IS NOT NULL
                        AND start_date_focus > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                        GROUP BY campus_id) AS F"), function ($join) {
                    $join->on('C.id', '=', 'F.campus_id');
                })
                ->whereColumn('T.start_date_focus', '=', 'F.start_date_focus')
                ->where('CU.user_id', '=', auth()->id())
                ->pluck('name', 'id');

            return $training;
        } catch (\Exception $e) {
            // Registra el error en los registros
            Log::error($e->getMessage());
            return response()->json(['error' => 'Ocurrió un error en el servidor.'], 500);
        }
    }

    public function staffFocus($training_id)
    {
        return Staff::from('fyl_staff as S')
                ->join('fyl_participants as P', 'S.participant_DNI', '=', 'P.DNI')
                ->where('S.training_id', $training_id)
                ->get();

    }

    public function lifeEnroller($training_id)
    {

        return DB::table('fyl_life_participants as LP')
            ->join('fyl_participants as P', 'LP.participant_DNI', '=', 'P.DNI')
            ->select('P.id', DB::raw("CONCAT(P.surnames, ' ', P.names) as name"))
            ->where('LP.training_id', '=', $training_id)
            ->where('LP.attendance_status', '=', 'ASISTIÓ')
            ->orderBy('name')
            ->get();
    }

    public function paises()
    {
        // Lógica para cargar la lista de países
    }

    public function cantones($provincia)
    {
        // Lógica para cargar la lista de cantones de la provincia especificada
    }

    public function parroquias($canton)
    {
        // Lógica para cargar la lista de parroquias del cantón especificado
    }
}
