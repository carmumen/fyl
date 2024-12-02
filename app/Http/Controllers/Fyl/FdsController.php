<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveFdsRequest;
use App\Models\Fyl\Fds;
use App\Models\Fyl\FdsTeam;
use App\Models\Fyl\Training;
use App\Models\Fyl\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class FdsController extends Controller
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

        $search = $request->input('search');
        $pag = $request->input('pag') ?: 30;
        
        $userId = auth()->id();

        $fds = Fds::from('fyl_fds as F')
            ->join('fyl_campus as C', 'F.campus_id', '=', 'C.id')
            ->join('fyl_campus_user as CU', 'C.id', 'CU.campus_id')
            ->join('fyl_training as T', 'F.training_in_game', '=', 'T.id')
            ->select(
                'F.id',
                'C.name',
                DB::raw("CONCAT('FYL - ', T.number) as training_in_game"),
                'F.start_date',
                'F.end_date'
            )
            ->where('CU.user_id', $userId)
            ->where('C.name', 'LIKE', '%' . $search . '%')
            ->orderBy('F.training_in_game', 'desc')
            ->paginate($pag);


        $fds->appends(['search' => $search, 'pag' => $pag]);

        $contador = ($fds->currentPage() - 1) * $fds->perPage() + 1;

        // Asignar el número secuencial a cada registro
        foreach ($fds as $fdsItem) {
            $fdsItem->secuencial = $contador;
            $contador++;
        }

        if (empty($requestData)) {
            return view('fyl/fds.index', [
                'fds' => $fds,
                'search' => $search,
                'pag' => $pag,
                'campusId' => 0
            ]);
        } else {
            return view('fyl/fds.index', [
                'fds' => $fds,
                'search' => $search,
                'pag' => $pag,
                'campusId' => $request->campus_id
            ]);
        }
    }


    public function create()
    {
        $userId = auth()->id();

        $campus = DB::table('fyl_campus as c')
            ->join('fyl_campus_user as cu', 'c.id', 'cu.campus_id')
            ->where('cu.user_id', $userId)
            ->select('c.id', 'c.name')
            ->pluck('name', 'id');

        return view('fyl/fds/create', [
            'campus' => $campus,
            'campusId' => 0,
            'fds' => new Fds
        ]);
    }


    public function store(SaveFdsRequest $request)
    {
        Fds::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Fds.index')->with('status', 'Fds create!');
    }


    public function show(Fds $fds)
    {
    }

    public function edit($id)
    {
        $userId = auth()->id();

        $campus = DB::table('fyl_campus as c')
            ->join('fyl_campus_user as cu', 'c.id', 'cu.campus_id')
            ->where('cu.user_id', $userId)
            ->select('c.id', 'c.name')
            ->pluck('name', 'id');

        $fds = Fds::findOrFail($id);

        return view('fyl/fds/edit', [
            'campus' => $campus,
            'campusId' => $fds->campus_id,
            'fds' => $fds
        ]);
    }


    public function update(SaveFdsRequest $request, $id)
    {
        $fds = Fds::findOrFail($id);

        $fds->update($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Fds.index', $fds)->with('status', 'FDS updated!');
    }
    

    public function destroy($id)
    {
        try {
            $fds = Fds::findOrFail($id);
            $fds->delete();
            return to_route('Fds.index')->with('status', __('Fds deleted!'));
        } catch (Exception $e) {
            return to_route('Fds.index')->with('errors', 'El FDS no puede ser eliminado.');
        }
    }

    ///MANEJO DE MIEMBROS DE EQUIPO

    public function teams($id)
    {
        $fds = Fds::findOrFail($id);

        $fechaActual = date('Y-m-d');

        $training = DB::table('fyl_training_in_game_view')
            ->where('campus_id', $fds->campus_id)
            //->where('start_date_life','<=', $fechaActual)
            ->where('end_date_life', '>=',$fechaActual )
            ->orderBy('id','desc')
            ->pluck('name','id');

        $coach = DB::table('th_employees')
            ->where('job_title_id', 2)
            ->select(
                'DNI',
                'surnames',
                'names',
                DB::RAW("CONCAT(surnames,' ',names) as name")
            )
            ->orderBy('surnames', 'asc')
            ->orderBy('names', 'asc')
            ->pluck('name','DNI');

            $fdsTeam = DB::table('fyl_fds_team')->where('fds_id',$fds->id)->get();
            
     
        $campus_id = $fds->campus_id;
        
        $count = DB::table('fyl_training')
                    ->where('campus_id',$campus_id)
                    ->where('start_date_life', '<', function ($query) {
                        $query->select('start_date_focus')
                              ->from('fyl_training')
                              ->where('start_date_focus', '>=', DB::raw('CURRENT_DATE'))
                              ->limit(1);
                    })
                    ->count();

        
        $training_couch = [];
        
        if($campus_id == 1)
        {
            $training_couch = DB::table('th_employees')
            ->where('training_id',14)
            ->where('status','ACTIVE')
            ->select(
                'DNI',
                'surnames',
                'names',
                DB::RAW("CONCAT(UPPER(surnames),' ',UPPER(names)) as name")
            )
            ->orderBy('surnames', 'asc')
            ->orderBy('names', 'asc')
            ->pluck('name','DNI');
        }

        return view('fyl/fds/team', [
            'fds' => $fds,
            'training' => $training,
            'coach' => $coach,
            'fdsTeam' => $fdsTeam,
            'campus_id' => $campus_id,
            'count' => $count
        ]);
        
        
    }


    public function teamsRegister(Request $request)
    {
        if($request->training_id_1FDS){
            $t_1 = $request->training_id_1FDS;
            $c_1 = $request->DNI_coach_1FDS;
        }
        
        if($request->training_id_2FDS){
            $t_2 = $request->training_id_2FDS; 
            $c_2 = $request->DNI_coach_2FDS;
        }
        
        if($request->training_id_3FDS){
            $t_3 = $request->training_id_3FDS;
            $c_3 = $request->DNI_coach_3FDS;
        }
        
        $t_4 = $request->academia ?: null;
        $c_4 = $request->DNI_coach_academia ?: null;
        
        $validatedData = [];
        
        $data = [];
        
        if($request->training_id_3FDS){
            $validatedData = Validator::make(
                $request->all(),
                [
                    'fds_id' => ['required'],
                    'training_id_1FDS' => ['required'],
                    'training_id_2FDS' => ['required'],
                    'training_id_3FDS' => ['required'],
                    'DNI_coach_1FDS' => ['required'],
                    'DNI_coach_2FDS' => ['required'],
                    'DNI_coach_3FDS' => ['required'],
                ]
            );
            
            $validatedData->after(function ($validator) use ($request) {
            
                if($request->training_id_1FDS == $request->training_id_2FDS )
                {
                    $validator->errors()->add('error', 'El entrenamiento NO se debe repetir');
                }
    
                if($request->DNI_coach_1FDS == $request->DNI_coach_2FDS )
                {
                    $validator->errors()->add('error', 'El Entrenador NO se debe repetir');
                }
    
                if($request->training_id_1FDS == $request->training_id_2FDS || $request->training_id_1FDS == $request->training_id_3FDS || $request->training_id_2FDS == $request->training_id_3FDS)
                {
                    $validator->errors()->add('error', 'El entrenamiento NO se debe repetir');
                }
    
                if($request->DNI_coach_1FDS == $request->DNI_coach_2FDS || $request->DNI_coach_1FDS == $request->DNI_coach_3FDS || $request->DNI_coach_2FDS == $request->DNI_coach_3FDS)
                {
                    $validator->errors()->add('error', 'El Entrenador NO se debe repetir');
                }
    
            });
            
            $data = [
                'fds_id' => $request->fds_id,
                'training_id_1FDS' => $t_1,
                'DNI_coach_1FDS' => $c_1,
                'training_id_2FDS' => $t_2,
                'DNI_coach_2FDS' => $c_2,
                'training_id_3FDS' => $t_3,
                'DNI_coach_3FDS' => $c_3,
                'academia' => $t_4,
                'DNI_coach_academia' => $c_4,
                'user_id' => auth()->id(),
            ];

        } else if($request->training_id_2FDS){
            $validatedData = Validator::make(
                $request->all(),
                [
                    'fds_id' => ['required'],
                    'training_id_1FDS' => ['required'],
                    'training_id_2FDS' => ['required'],
                    'DNI_coach_1FDS' => ['required'],
                    'DNI_coach_2FDS' => ['required'],
                ]
            );
            
            $validatedData->after(function ($validator) use ($request) {
            
                if($request->training_id_1FDS == $request->training_id_2FDS )
                {
                    $validator->errors()->add('error', 'El entrenamiento NO se debe repetir');
                }
    
                if($request->DNI_coach_1FDS == $request->DNI_coach_2FDS )
                {
                    $validator->errors()->add('error', 'El Entrenador NO se debe repetir');
                }
            });
            
            $data = [
                'fds_id' => $request->fds_id,
                'training_id_1FDS' => $t_1,
                'DNI_coach_1FDS' => $c_1,
                'training_id_2FDS' => $t_2,
                'DNI_coach_2FDS' => $c_2,
                'academia' => $t_4,
                'DNI_coach_academia' => $c_4,
                'user_id' => auth()->id(),
            ];
        } else if($request->training_id_1FDS){
            $validatedData = Validator::make(
                $request->all(),
                [
                    'fds_id' => ['required'],
                    'training_id_1FDS' => ['required'],
                    'DNI_coach_1FDS' => ['required'],
                ]
            );
            
            $data = [
                'fds_id' => $request->fds_id,
                'training_id_1FDS' => $t_1,
                'DNI_coach_1FDS' => $c_1,
                'academia' => $t_4,
                'DNI_coach_academia' => $c_4,
                'user_id' => auth()->id(),
            ];
        }

        if ($validatedData && $validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        
        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }
        

        $fds = Fds::findOrFail($request->fds_id);

        $fdsTeam = DB::table('fyl_fds_team')->where('fds_id',$request->fds_id)->first();

        //return $fdsTeam;

        if($fdsTeam)
        {
            $fdsTeamArray = (array) $fdsTeam;

            FdsTeam::updateOrInsert(['id' => $fdsTeamArray['id']], $data);
        }
        else
        {
            FdsTeam::create($data);
        }
        
        if($request->academia)
        {
            FdsTeam::updateOrInsert(['id' => $fdsTeamArray['id']], $data);
        }

        return to_route('Fds.index', $fds)->with('status', 'Team updated!');
    }
}
