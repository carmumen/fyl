<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Models\TuModelo; // Asegúrate de importar el modelo correcto

class ListController extends Controller
{
    public function listFocus($id)
    {
        // Lógica para obtener datos y mostrar la vista
        $datos = DB::table('fyl_focus_participants AS FP')
        ->join('fyl_participants AS P', 'FP.participant_DNI', '=', 'P.DNI')
        ->join('fyl_training AS T', 'P.training_id_enroller', '=', 'T.id')
        ->leftJoin('fyl_participants AS PE', 'P.DNI_enroller', '=', 'PE.DNI')
        ->where('FP.training_id', 5)
        ->select(
            DB::raw('CONCAT(P.surnames, " ", P.names) AS NOMBRE'),
            'T.team_name AS EQUIPO',
            'P.nickname AS GAFETE',
            'P.phone AS NUMERO',
            DB::raw('CONCAT(PE.nickname, " ", PE.surnames) AS INVITA'),
            'PE.phone AS NUMERO_ENROLADOR'
        )
        ->get();

        $contador = 1;

        // Asignar el número secuencial a cada registro
        foreach ($datos as $datosItem) {
            $datosItem->secuencial = $contador;
            $contador++;
        }

        return view('/fyl/focusParticipants.list', ['datos' => $datos, 'trainingId' =>  $id]); // Reemplaza 'tu_vista' con la vista que desees mostrar
    }

    public function listLife($id)
    {
        // Lógica para obtener datos y mostrar la vista
        $datos = DB::table('fyl_focus_participants AS FP')
        ->join('fyl_participants AS P', 'FP.participant_DNI', '=', 'P.DNI')
        ->join('fyl_training AS T', 'P.training_id_enroller', '=', 'T.id')
        ->leftJoin('fyl_participants AS PE', 'P.DNI_enroller', '=', 'PE.DNI')
        ->where('FP.training_id', 5)
        ->select(
            DB::raw('CONCAT(P.surnames, " ", P.names) AS NOMBRE'),
            'T.team_name AS EQUIPO',
            'P.nickname AS GAFETE',
            'P.phone AS NUMERO',
            DB::raw('CONCAT(PE.nickname, " ", PE.surnames) AS INVITA'),
            'PE.phone AS NUMERO_ENROLADOR'
        )
        ->get();

        $contador = 1;

        // Asignar el número secuencial a cada registro
        foreach ($datos as $datosItem) {
            $datosItem->secuencial = $contador;
            $contador++;
        }

        return view('/fyl/focusParticipants.list', ['datos' => $datos, 'trainingId' =>  $id]); // Reemplaza 'tu_vista' con la vista que desees mostrar
    }
}
