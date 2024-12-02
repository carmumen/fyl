<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SavefocusRezagadosRequest;
use App\Models\Global\Catalog;
use App\Models\Fyl\FocusParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Training;
use App\Models\Fyl\TrainingTeam;
use App\Models\Fyl\Campus;
use App\Models\Fyl\FollowFocus;
use App\Models\Fyl\Staff;
use App\Models\Users;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class FocusRezagadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $requestData = $request->all();
        
        //return $requestData;
        
        $search = $request->input('search') ?: '';

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);
        
        $userId = auth()->id();
        
        $campuses = Users::find($userId)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        
        $data = [
                'campus' => $campuses,
                'campusId' => 0
            ];
            
        //return $data;   

        if (empty($requestData)) {
            return view('fyl/focusRezagados.index', $data);
        } else {
            
            $campusId = $request->campus_id;

            $participants_rezagados = DB::select( 'CALL fyl_get_focus_rezagados_sp(?)', [$campusId] );
            
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($participants_rezagados as $participants_rezagadosItem) {
                $participants_rezagadosItem->secuencial = $contador;
                $contador++;
            }

            $data = [
                'campus' => $campuses,
                'campusId' => $campusId,
                'participants_rezagados' => $participants_rezagados,
            ];
            
            return view('fyl/focusRezagados.index', $data);
        }

    }

    public function create()
    {
    }
    public function store(Request $request)
    {
        return to_route('FocusRezagados.index',['campus_id'=>$request->campus_id]);
    }
    public function show(Request $request)
    {
        
    }

    public function edit($id)
    {
        $focusRezagados = FocusParticipants::from('fyl_focus_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_participants as PE', 'P.DNI_enroller', '=', 'PE.DNI')
            ->select(
                'FP.id',
                'FP.participant_DNI',
                'FP.training_id',
                'P.names',
                'P.surnames',
                'P.phone',
                'P.nickname',
                'P.training_id_enroller',
                DB::raw("CONCAT(PE.names,' ',PE.surnames)  as enroller"),
                'PE.phone as enroller_phone'
            )
            ->where('FP.id', $id)
            ->first();

        $followUp = FollowFocus::from('fyl_follow_focus as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select('FF.date_call',
                    'FF.confirm_assistance',
                    'FF.summary_call',
                    'U.name',
                    'FF.created_at')
            ->where('program_id', 2)
            ->where('participant_DNI', $focusRezagados->participant_DNI)
            ->where('training_id', $focusRezagados->training_id)->get();
            
        $data = [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'focusRezagados' => $focusRezagados
        ];
        
        //return $data;

        return view('fyl/focusRezagados/edit', $data);
    }

    public function update(Request $request, $id)
    {
        //return $request;
        $focusRezagados = FocusParticipants::from('fyl_focus_participants as FP')
                                        ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
                                        ->leftjoin('fyl_participants as PE', 'P.DNI_enroller', '=', 'PE.DNI')
                                        ->select(
                                            'FP.id',
                                            'FP.participant_DNI',
                                            'FP.training_id',
                                            'P.names',
                                            'P.surnames',
                                            'P.phone',
                                            'P.nickname',
                                            'P.training_id_enroller',
                                            'FP.record_mode',
                                            'P.city_of_residenceT',
                                            DB::raw("CONCAT(PE.names,' ',PE.surnames)  as enroller"),
                                            'PE.phone as enroller_phone'
                                        )
                                        ->where('FP.id', $id)
                                        ->first();

        $validator = Validator::make($request->all(), [
            'training_id' => ['required'],
            'program_id' => ['required'],
            'type_call' => ['required'],
            'participant_DNI' => ['required'],
            'date_call' => ['required'],
            'confirm_assistance' => ['required'],
        ]);
        
        if ($validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return back()->withErrors($validator)->withInput();
        }
        
        $follow_type_call = $request->input('type_call');
        $follow_confirm_assistance = $request->input('confirm_assistance');
        
        if($follow_confirm_assistance != 'SI')
        {
            $follow_type_call = 'Recuperación';
        }

        $follow = [
            'training_id' => $request->input('training_id'),
            'program_id' => $request->input('program_id'),
            'type_call' => $follow_type_call,
            'participant_DNI' => $request->input('participant_DNI'),
            'date_call' => $request->input('date_call'),
            'confirm_assistance' => $follow_confirm_assistance,
            'summary_call' => $request->input('summary_call'),
            'user_id' => auth()->id()
        ];

        FollowFocus::create($follow);
        
        $data = [
                    $request->input('participant_DNI'),
                    $request->input('campus_id'),
                    $request->input('training_id'),
                    auth()->id()
                ];
                
        //return $data;
        
        if($follow_confirm_assistance == 'SI')
        {
            DB::select(
                'CALL insert_focus_rezagado_recuperado(?, ?, ?, ?)', $data );
        }
        
        
        return to_route('FocusRezagados.index',['campus_id'=>$request->campus_id]);


    }

    public function destroy(focusRezagados $focusRezagados)
    {
       
    }

    public function call(Request $request)
    {

        //return $request;
        $focusParticipants = DB::table('fyl_get_focus_rezagados_view as FP')
            ->join('fyl_get_focus_rezagados_recuperados_training_view as R','FP.campus_id','=','R.campus_id')
            ->select(
                'FP.id',
                'FP.DNI as participant_DNI',
                'FP.training_id_focus as training_id',
                'FP.training_id_enroller',//
                'R.record_mode',//
                'FP.names',//
                'FP.surnames',
                'FP.phone',
                'FP.phone2',
                'FP.nickname',//
                'FP.city_of_residenceT',
                'enrolador as enroller',
                'phone_enroller as enroller_phone'
            )
            ->where('FP.id', $request->id)
            ->first();
            
        //   return $focusParticipants;
        
        $yesterday = Carbon::now()->subDay()->toDateString();
           
        $training = DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->select('C.id as campus_id', 'T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->where('start_date_focus', '>', $yesterday)
            ->get();
            


        $followUp = FollowFocus::from('fyl_follow_focus as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->join('fyl_training as T', 'FF.training_id', '=', 'T.id')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->select(
                DB::raw("CONCAT(C.name, ' FYL ', T.number) as campus"),
                'FF.date_call',
                'FF.type_call',
                'FF.confirm_assistance',
                'FF.summary_call',
                'U.name',
                'FF.created_at'
            )
            ->where('program_id', 2)
            ->where('participant_DNI', $focusParticipants->participant_DNI)
            ->orderBy('FF.date_call','DESC')
            ->get();

        $data = [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'focusParticipants' => $focusParticipants,
            'type_call' => $request->type_call,
            'campusId' => $request->campus_id,
            'training' => $training,
            'trainingId' => $request->training_id,
        ];
        //return $data;
        
        return view('fyl/focusRezagados/edit', $data);
        
    }

    
}
