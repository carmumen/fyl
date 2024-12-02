<?php

namespace App\Http\Controllers\Coordinacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


use App\Models\Users;

use Exception;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;


class ListadoController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function listadoEnJuego(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $requestData = $request->all();
        
        //return $requestData;
        
        $user_id = auth()->id();
        
        $campuses = Users::find($user_id)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        
        
        if (empty($requestData)) {
            return view('coordinacion.listado-equipos-en-juego', [
                'campus' => $campuses,
                'campusId' => 0,
            ]);
        }
        
        
        if($request->campus_id != "0" && $request->training_id == "0" )
        {
            
            $training = DB::select('CALL get_fyl_equipo_en_juego_id (?)', [$request->campus_id ]);
            //return $training;
             return view('coordinacion.listado-equipos-en-juego', [
                'campus' => $campuses,
                'campusId' => $request->campus_id,
                'training' => $training,
                'trainingId' => 0
            ]);
        }
        
        
        $training = DB::select('CALL get_fyl_equipo_en_juego_id (?)', [$request->campus_id ]); 
        
        $trainingInGame = DB::select('CALL get_fyl_equipo_en_juego (?)', [$request->training_id ]);
        
        $contador = 1;
        
        foreach ($trainingInGame as $trainingInGameItem) {
            $trainingInGameItem->secuencial = $contador;
            $contador++;
        }
        
        return view('coordinacion/listado-equipos-en-juego',[
                'campus' => $campuses,
                'campusId' => $request->campus_id,
                'training' => $training,
                'trainingId' => $request->training_id,
                'trainingInGame' => $trainingInGame,
            ]);
    }
    
   
}
