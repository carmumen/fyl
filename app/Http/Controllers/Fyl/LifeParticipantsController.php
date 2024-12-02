<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use App\Models\Global\Catalog;
use App\Models\Fyl\LifeParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Training;
use App\Models\Fyl\TrainingTeam;
use App\Models\Fyl\FollowLife;
//use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ConsultaLog;

use Exception;
use PhpParser\Node\Stmt\Return_;

class LifeParticipantsController extends Controller
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
        
        //return $request;

        $search = $request->input('search') ?: '%';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado
        
        DB::select('CALL fyl_user_life_IU()');
        
        $result = DB::select('CALL fyl_get_training_plus(?)', [$userId]);
        
        $collection = collect($result);

        $trainingNext = $collection->pluck('name', 'id')->toArray();
        
        //return $trainingNext;

        if (empty($requestData)) {
            return view('fyl/lifeParticipants.index', [
                'trainingNext' => $trainingNext,
                'trainingIdNext' => 0,
                //'training' => $training,
                //'trainingId' => 0
            ]);
        } else {
            
            $trainingIdNext = $request->trainingIdNext;
            $trainingId = $request->training_id;
        
            //return $trainingId;
            
            if($trainingId != 0)
            {
                
                //$level = $request->level;
                //return $level;
    
                $lifeParticipants = DB::select('CALL get_fyl_life_participants1(?,?,?)', [$trainingIdNext, $trainingId, $search]);
                
                //return $lifeParticipants;
                
                $consulta = 'CALL get_fyl_life_participants1(' . $trainingIdNext . ','.$trainingId.','.$search.')';
            
                ConsultaLog::create(['consulta' => $consulta, 'user_id' => $userId]);
                
                $contador = 1;
                //return $lifeParticipants;
    
                foreach ($lifeParticipants as $lifeParticipantsItem) {
                    $lifeParticipantsItem->secuencial = $contador;
                    $contador++;
                }
                
                if(!$lifeParticipants)
                {
                    $level = 1;
                }
                else
                {
                    $level = $lifeParticipants[0]->level;
                }
                
                
                
                
                
                $rezagados = [];
    /*
                if($level == 1){
                    $result = DB::select('CALL get_fyl_life_rezagado(?)', [$trainingId]);
    
                    $collection = collect($result);
    
                    $rezagados = $collection->pluck('name', 'id')->toArray();
                }*/
                
                //$training = $this->get_training_next($trainingIdNext);
    
                $data = [
                    'training' => $request->training,
                    'trainingId' => $trainingId,
                    'trainingNext' => $trainingNext,
                    'trainingIdNext' => $request->trainingIdNext,
                    'lifeParticipants' => $lifeParticipants,
                    'rezagados' => [],//$rezagados,
                    // 'search' => $search,
                    'participantsLife' => new LifeParticipants()
                ];
                return view('fyl/lifeParticipants.index', $data);
            }
            else
            {
                //return $request->trainingIdNext;
                $data = [
                    'trainingNext' => $trainingNext,
                    'trainingIdNext' => $request->trainingIdNext,
                    'training' => $this->get_training_next($trainingIdNext),
                    'trainingId' => $request->training_id
                    
                ];
                return view('fyl/lifeParticipants.index', $data);
            }
        }
    }

    public function get_training_next($trainingIdNext)
    {
        $userId = auth()->id();
        
        //return $trainingIdNext;
        
        $consulta = 'CALL fyl_get_training_next_life2(' . $trainingIdNext . ')';
        
        ConsultaLog::create(['consulta' => $consulta, 'user_id' => $userId]);

        $result = DB::select('CALL fyl_get_training_next_life2(?)', [$trainingIdNext]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search'); // Obtener el término de búsqueda del formulario

        return $searchTerm;

        // Realizar la lógica de búsqueda y devolver resultados
    }

    public function create()
    {
        $city = City::from('global_cities as CI')
            ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
            ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
            ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
            ->select(
                'CI.id',
                DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
            )
            ->groupby('CI.id', 'CO.name', 'P.name', 'C.name')
            ->orderBy('CO.name', 'asc')
            ->orderBy('P.name', 'asc')
            ->orderBy('CI.name', 'asc')->pluck('name', 'id');

        return view('fyl/lifeParticipants/create', [
            'city' => $city,
            'lifeParticipants' => new LifeParticipants
        ]);
    }
    public function store(Request $request)
    {
        $trainingIdNext = $request->training_id_next;
        $trainingId = $request->training_id;
        $userId = auth()->id();
        
        if($trainingId == 14 )
        {
            DB::select('CALL insert_life_participants_academia(?, ?, @outputLevel)', [$trainingId, $userId]);
            
            $outputLevel = DB::select('SELECT @outputLevel')[0]->{'@outputLevel'};
            
            $consulta = 'CALL insert_life_participants_academia(' . $trainingId . ','.$userId.')';
        
            ConsultaLog::create(['consulta' => $consulta, 'user_id' => $userId]);
        }
        else {
            DB::select('CALL insert_life_participants1(?, ?, ?)', [$trainingIdNext, $trainingId, $userId]);
            
            $consulta = 'CALL insert_life_participants1(' . $trainingIdNext . ','.$trainingId.','.$userId.')';
        
            ConsultaLog::create(['consulta' => $consulta, 'user_id' => $userId]);
        }
        
        $training = $this->get_training_next($trainingIdNext);
        
        $data = [
            'trainingIdNext' => $trainingIdNext, 
            'training' => $training, 
            'training_id' => $trainingId
            ];

        return to_route('LifeParticipants.index', $data)->with('status', 'Created!');
    }
    
    public function storeNext(Request $request)
    {
        
        $training = $this->get_training_next($request->training_id_next);
        
        //return $request->training_id_next;
        
        return to_route('LifeParticipants.index', ['training' => $training, 'trainingIdNext' => $request->training_id_next, 'training_id' => 0]);
       
    }


    public function show(Request $request)
    {
        return 'Hola';
    }

    public function edit($id)
    {

        $lifeParticipants = LifeParticipants::from('fyl_life_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_participants as PE', 'P.DNI_enroller', '=', 'PE.DNI')
            ->select(
                'FP.id',
                'FP.participant_DNI',
                'FP.training_id',
                'FP.level',
                'P.names',
                'P.surnames',
                'P.phone',
                'P.nickname',
                DB::raw("CONCAT(PE.names,' ',PE.surnames)  as enroller"),
                'PE.phone as enroller_phone'
            )
            ->where('FP.id', $id)
            ->first();


        $followUp = FollowLife::from('fyl_follow_life as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select('*')
            ->where('training_id', $lifeParticipants->training_id)
            ->where('level', $lifeParticipants->level)
            ->where('participant_DNI', $lifeParticipants->participant_DNI)->get();



        return view('fyl/lifeParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'lifeParticipants' => $lifeParticipants
        ]);
    }

    public function update(Request $request, $id)
    {
        $lifeParticipants = LifeParticipants::from('fyl_life_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->select(
                'FP.id',
                'FP.participant_DNI',
                'FP.training_id',
                'FP.level',
                'P.names',
                'P.surnames',
                'P.phone',
                'P.nickname'
            )
            ->where('FP.id', $id)
            ->first();

        //return $lifeParticipants;


        $validator = Validator::make($request->all(), [
            'training_id' => ['required'],
            'program_id' => ['required'],
            'level' => ['required'],
            'participant_DNI' => ['required'],
            'date_call' => ['required'],
            'confirm_assistance' => ['required'],
            'summary_call' => ['required'],
        ]);

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $follow = [
            'training_id' => $request->input('training_id'),
            'level' => $request->input('level'),
            'participant_DNI' => $request->input('participant_DNI'),
            'date_call' => $request->input('date_call'),
            'confirm_assistance' => $request->input('confirm_assistance'),
            'summary_call' => $request->input('summary_call'),
            'user_id' => auth()->id()
        ];

        FollowLife::create($follow);



        $followUp = FollowLife::from('fyl_follow_life as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select('*')
            ->where('training_id', $lifeParticipants->training_id)
            ->where('level', $lifeParticipants->level)
            ->where('participant_DNI', $lifeParticipants->participant_DNI)->get();



        return view('fyl/lifeParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'lifeParticipants' => $lifeParticipants
        ]);
    }

    public function destroy(LifeParticipants $lifeParticipants)
    {
        try {
            $lifeParticipants->delete();
        } catch (Exception $e) {
            return to_route('LifeParticipants.index')->with('errors', 'La Sede no puede ser eliminada.');
        }

        return to_route('LifeParticipants.index')->with('status', __('LifeParticipants deleted!'));
    }

    public function team(Request $request)
    {
        $requestData = $request->all();

        $training = DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join(DB::raw('(select campus_id, min(start_date_life) start_date_life
                    from fyl_training T
                    where start_date_life is not null
                    and start_date_life > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                    group by campus_id) as F'), function ($join) {
                $join->on('C.id', '=', 'F.campus_id')
                    ->whereColumn('T.start_date_life', '=', 'F.start_date_life');
            })
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->pluck('name', 'id');



        $lifeTeamEmpty = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', 999999999)
            ->where('program', 'Life')->get();

        $lifeParticipantsEmpty = LifeParticipants::from('fyl_life_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->select(
                'FP.id',
                'FP.training_id',
                'FP.record_mode',
                'FP.participant_DNI',
                'FP.master_life_DNI',
                'FP.attendance_status',
                'FP.statement',
                'FP.attendance_status',

                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                'P.nickname',
                'P.phone',
            )
            ->where('FP.training_id', 999999999)
            ->where('FP.attendance_status', 'ASISTIO')
            ->orderBy('participant', 'asc')
            ->get();

        $lifeTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $request->training_id)
            ->where('program', 'Life')->get();

        $lifeParticipants = LifeParticipants::from('fyl_life_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->select(
                'FP.id',
                'FP.training_id',
                'FP.record_mode',
                'FP.participant_DNI',
                'FP.master_life_DNI',
                'FP.attendance_status',
                'FP.statement',
                'FP.attendance_status',

                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                'P.nickname',
                'P.phone',
            )
            ->where('FP.training_id', $request->training_id)
            ->where('FP.attendance_status', 'ASISTIO')
            ->orderBy('participant', 'asc')
            ->get();

        //return $lifeTeam;

        if (empty($requestData)) {
            return view('fyl/lifeParticipants.team', [
                'training' => $training,
                'lifeTeam' =>  $lifeTeamEmpty,
                'lifeParticipants' => $lifeParticipantsEmpty,
            ]);
        } else {
            return view('fyl/lifeParticipants.team', [
                'training' => $training,
                'lifeTeam' =>  $lifeTeam,
                'lifeParticipants' => $lifeParticipants,
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $newStatus = $request->input('attendance_status');
        $day = $request->input('attendance_day');

        $lifeParticipants = LifeParticipants::find($id);



        if ($lifeParticipants) {
            if ($day == 'friday') {
                $lifeParticipants->friday_attended = $newStatus;
                $lifeParticipants->saturday_attended = $newStatus;
                $lifeParticipants->sunday_attended = $newStatus;
            }
            if ($day == 'saturday') {
                $lifeParticipants->saturday_attended = $newStatus;
                $lifeParticipants->sunday_attended = $newStatus;
            }
            if ($day == 'sunday') {
                $lifeParticipants->sunday_attended = $newStatus;
            }
            $lifeParticipants->save();
        }
        return to_route('LifeParticipants.index');
    }

    public function updateStatement(Request $request, $id)
    {
        $newStatement = $request->input('statement');
        $day = $request->input('day');


        $lifeParticipants = LifeParticipants::find($id);

        if ($lifeParticipants) {
            if ($day == 'friday') {
                $lifeParticipants->friday_statement = $newStatement;
            }
            if ($day == 'saturday') {
                $lifeParticipants->saturday_statement = $newStatement;
            }
            if ($day == 'sunday') {
                $lifeParticipants->sunday_statement = $newStatement;
            }
            $lifeParticipants->save();
        }
        return to_route('LifeParticipants.index');
    }
    
    public function left_over(Request $request)
    {
        //return $request;
        
        $training_in_game = $request->input('training_in_game');
        $parts = explode('|', $request->input('dni_rezagado'));

        $training_id = $parts[0];
        $training_id_enroller = $parts[1];
        $DNI_enroller = $parts[2];
        $participant_DNI = $parts[3];
        $record_mode = $parts[4];
        $userId = auth()->id();

        DB::select('CALL insert_life_participants_left_over(?,?,?,?,?)', [
            $training_in_game,
            $training_id,
            $participant_DNI,
            $record_mode,
            $userId]);
            

        return to_route('LifeParticipants.index', [
            'trainingIdNext' => $training_in_game,
            'training_id' => $training_id,
            'level' => 1,
        ])->with('status', 'Campus updated!');

        return view('fyl/lifeParticipants.index', [
            'trainingId' => ['trainingId' => $request->rezagados],
        ]);
    }
}
