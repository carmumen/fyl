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
use App\Models\Coordinacion\Promesa;
use App\Models\Coordinacion\Contrato;
use App\Models\Coordinacion\Observacion;
use App\Models\Coordinacion\ObservacionContrato;
//use App\Http\Requests\SavePromesaRequest;

use Exception;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;


class PromesaController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $userId = auth()->id();
        
        $training = DB::select('CALL fyl_get_life_activo(?)', [$userId]); 
        
        $trainingOptions = collect($training)->pluck('name', 'id');
        
        $requestData = $request->all();
        
        
        if (empty($requestData)) {
            return view('coordinacion/index', [
                'training' => $trainingOptions,
                'trainingId' => 0,
            ]);
            
        } 
            
        $trainingId = $request->input('training_id'); 
        
        $Promesa = DB::select('CALL fyl_get_participants_promesas(?)', [$trainingId]);
        
        //return $Promesa;
        
        $contador = 1;

        // Asignar el n√∫mero secuencial a cada registro
        foreach ($Promesa as $PromesaItem) {
            $PromesaItem->secuencial = $contador;
            $contador++;
        }
        
        return view('coordinacion/index',[
                'training' => $trainingOptions,
                'trainingId' => $trainingId,
                'Promesa' => $Promesa,
            ]);
    }
    
    public function create(Request $request)
    {
        
    }
    
    public function store(Request $request)
    {
        
    }

    public function show()
    {
        
    }

    public function edit( $id)
    {
        $parts = explode('|', $id);
        
        $Promesa = Promesa::where('participant_DNI',$parts[0])
                    ->where('training_id',$parts[1])
                    ->get();

        $contador = 1;
        
        foreach ($Promesa as $PromesaItem) {
            $PromesaItem->secuencial = $contador;
            $contador++;
        }
        
        $Participante = '';
        
        if ($Promesa->isNotEmpty()) {
            $userId = $Promesa->first()->user_id; // Obt®¶n el user_id del primer elemento
        
            $usuario = DB::table('users as u')
                              ->where('id', $userId)
                              ->first(); // Usa first() para obtener un solo registro
        
            $Participante = $usuario->name;
            
        }
        
        $Observacion = DB::table('fyl_promesa_observacion as o')
                          ->join('fyl_participants_promesas as p', 'o.promesa_id','=','p.id')
                          ->join('users as u', 'o.user_id','=','u.id')
                          ->select('o.promesa_id',
                                   'o.updated_at',
                                   'u.name',
                                   'o.observacion'
                              )
                         ->where('p.participant_DNI',$parts[0])
                         ->where('p.training_id',$parts[1])
                       ->orderby('o.created_at','DESC')
                           ->get();
                           
        
        
        $Contrato = DB::table('fyl_participants_contrato as c')
                         ->where('c.participant_DNI',$parts[0])
                         ->where('c.training_id',$parts[1])
                           ->get();
                           
        
        
        $ObservacionContrato = DB::table('fyl_contrato_observacion as o')
                          ->join('fyl_participants_contrato as c', 'o.contrato_id','=','c.id')
                          ->join('users as u', 'o.user_id','=','u.id')
                          ->select('o.contrato_id',
                                   'o.updated_at',
                                   'u.name',
                                   'o.observacion'
                              )
                         ->where('c.participant_DNI',$parts[0])
                         ->where('c.training_id',$parts[1])
                       ->orderby('o.created_at','DESC')
                           ->get();
                           
        $data = [
                'Contrato' => $Contrato,
                'Promesa' => $Promesa,
                'Observacion' => $Observacion,
                'Participante' => $Participante,
                'ObservacionContrato' => $ObservacionContrato,
            ];
            
        //return $data;
        
        return view('coordinacion/edit',$data);
    }
    
    public function update(Request $request, Promesa $Promesa)
    {
        //return $request;
        $userId = auth()->id();
        
        $dataPromesa = [
                        'estado' => $request->input('estado'),
                        'user_aprobador' => $userId
                       ];
        
        $Promesa->update($dataPromesa);
        
        if($request->input('estado') == 'OBSERVADO')
        {
            $dataObservacion = [
                                'promesa_id' => $Promesa->id,
                                'observacion' => '*PROMESA '. $request->input('promesa') . ': *' . $request->input('observacion'),
                                'user_id' => $userId,
                            ];
                            
            Observacion::create($dataObservacion);
        }
        
        $id = $Promesa->participant_DNI.'|'.$Promesa->training_id;
    
        return redirect()->route('Promesa.edit', $id)->with('mensaje', 'Revisi√≥n registrada');
    }
    
    public function updateContrato(Request $request, Contrato $Contrato)
    {
        //return $request;
        
        $userId = auth()->id();
        
        $dataContrato = [
                        'estado' => $request->input('estado'),
                        'user_id' => $userId
                       ];
        
        $Contrato->update($dataContrato);
        
        if($request->input('estado') == 'OBSERVADO')
        {
            $dataObservacion = [
                                'contrato_id' => $Contrato->id,
                                'observacion' => '*CONTRATO, VISION Y PROPOSITO: *' . $request->input('observacion'),
                                'user_id' => $userId,
                            ];
                            
                            //return $dataObservacion;
                            
            ObservacionContrato::create($dataObservacion);
        }
        
        $id = $Contrato->participant_DNI.'|'.$Contrato->training_id;
    
        return redirect()->route('Promesa.edit', $id)->with('mensaje', 'Revisi√≥n registrada');
        
        
    }



    public function destroy(Promesa $Promesa)
    {
        
    }


}
