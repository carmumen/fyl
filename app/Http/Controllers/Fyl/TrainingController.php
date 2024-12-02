<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TH\Employee;
use App\Models\TH\JobTitle;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Programs;
use App\Models\Fyl\Training;
use App\Models\Fyl\TrainingTeam;
use App\Models\Fyl\LifeTemplate;
use App\Models\Fyl\LifeCalendar;
use App\Models\Fyl\Participants;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Exception;

class TrainingController extends Controller
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
        
        $search = $request->input('search');
        $pag = $request->input('pag') ?: 15;

        $training = Training::from('fyl_training as T')
            ->join('fyl_campus as C', 'C.id', '=', 'T.campus_id')
            ->join('fyl_campus_user as CU', 'C.id', '=', 'CU.campus_id')
            ->select(
                'T.id',
                'T.campus_id',
                'T.number',
                'T.start_date_focus',
                'T.end_date_focus',
                'T.start_date_your',
                'T.end_date_your',
                'T.start_date_life',
                'T.end_date_life',
                'T.team_name',
                'T.team_motto',
                'T.team_directory',
                'T.team_photo',
                'T.status',
                'C.name as campus'
            )
            ->where('CU.user_id', auth()->id())
            ->where('C.name', 'LIKE', '%' . $search . '%')
            ->orderBy('T.start_date_focus', 'DESC')
            ->paginate($pag);

        $training->appends(['search' => $search, 'pag' => $pag]);

        return view('fyl/training/index', ['training' => $training, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');

        return view('fyl/training/create', [
            'training' => new Training,
            'campus' => $campus
        ]);
    }

    public function store(Request $request)
    {
        try {

            session()->flash('tab', 2);
            $validator = Validator::make($request->all(), [
                'campus_id' => ['required'],
                'number' => ['required'],
                'status' => ['required']
            ]);
            if ($validator && $validator->fails()) {
                // Si la validación falla, redirige o muestra los errores
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $campus_name = Campus::where('id', $request->campus_id)->value('name');
            $entrenamiento = $campus_name . ' FYL - ' . $request->number;

            $data = $request->except(['_token', 'tagName']) + ['entrenamiento' => $entrenamiento, 'user_id' => auth()->id()];

            $training = Training::create($data);

            $training = Training::latest('id')->first();

            $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');

            $member = [];
            $focusTeam = [];
            $yourTeam = [];
            $lifeTeam = [];
            $lifeTemplate = [];
            $lifeCalendar = LifeCalendar::where('training_id', $training)
                ->orderBy('start_date', 'ASC')
               
                ->get();
            $rol = JobTitle::orderBy('name', 'ASC')->where('description', '=', 'Team')->pluck('name', 'id');

            return view('fyl/training/edit', [
                'training' => $training,
                'member' => $member,
                'focusTeam' => $focusTeam,
                'yourTeam' => $yourTeam,
                'lifeTeam' => $lifeTeam,
                'campus' => $campus,
                'lifeTemplate' => $lifeTemplate,
                'lifeCalendar' => $lifeCalendar,
                'rol' => $rol,
            ]);

            Training::create($request->validated() + ['user_id' => auth()->id()]);

            session()->flash('tab', 2);

            return to_route('Training.index')->with('status', 'Training create!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['status' => $e->getMessage()]);
        }
    }

    public function show(Training $Training)
    {
        return view('fyl/training/show', ['Training' => $Training]);
    }

    public function edit($id)
    {
        $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');

        $member = [];

        $training = Training::from('fyl_training as T')
            ->join('fyl_campus as C', 'C.id', '=', 'T.campus_id')
            ->select(
                'T.id',
                'T.campus_id',
                'T.number',
                'T.start_date_focus',
                'T.end_date_focus',
                'T.start_date_your',
                'T.end_date_your',
                'T.start_date_life',
                'T.end_date_life',
                'T.team_name',
                'T.team_motto',
                'T.team_directory',
                'T.team_photo',
                'T.status',
                'C.name as campus'
            )
            ->where('T.id', $id)->first();

        $focusTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $training->id)
            ->where('program', 'Focus')->get();

        $yourTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $training->id)
            ->where('program', 'Your')->get();



        $lifeTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $training->id)
            ->where('program', 'Life')->get();

        $rol = JobTitle::orderBy('name', 'ASC')->where('description', '=', 'Team')->pluck('name', 'id');

        $calendar = LifeCalendar::select('training_id', 'activity', 'start_date', 'start_hour')
            ->where('training_id', $training->id)
            ->pluck('activity');


        $lifeCalendar = LifeCalendar::where('training_id', $training->id)
            ->orderBy('start_date', 'ASC')
            ->orderBy('start_hour', 'ASC')
            ->get();

        // Obtener los registros de LifeTemplate que no están en LifeCalendar
        $lifeTemplate = LifeTemplate::orderBy('order', 'ASC')
            ->where('status', 'ACTIVE')
            ->whereNotIn('activity', $calendar)
            ->pluck('activity', 'id');

        //return $lifeCalendar;

        return view('fyl/training/edit', [
            'training' => $training,
            'member' => $member,
            'focusTeam' => $focusTeam,
            'yourTeam' => $yourTeam,
            'lifeTeam' => $lifeTeam,
            'campus' => $campus,
            'rol' => $rol,
            'lifeTemplate' => $lifeTemplate,
            'lifeCalendar' => $lifeCalendar,
        ]);
    }

    public function update(Request $request, $id)
    {
        //return $request;
        $validator = null;
        $tagName = $request->tagName;
        $form = $request->form;
        $Training = Training::findOrFail($id);



        $Training->user_id = auth()->id();

        switch ($tagName) {
            case 1:
                $validator = Validator::make($request->all(), [
                    'campus_id' => ['required'],
                    'number' => ['required'],
                    'status' => ['required']
                ]);
                break;
            case 2:
                session()->flash('tab', 2);
                session()->flash('form', $form);
                if ($form == 'fechaFocus') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'start_date_focus' => ['required', 'date'],
                            'end_date_focus' => ['required', 'date', 'after_or_equal:start_date_focus']
                        ],
                        $customMessages = [
                            'start_date_focus.required' => 'Fecha requerida',
                            'start_date_focus.date' => 'Ingrese una fecha',
                            'end_date_focus.required' => 'Fecha requerida',
                            'end_date_focus.date' => 'Ingrese una fecha',
                            'after' => 'Fin debe ser mayor que Inicio',
                        ]
                    );
                }

                if ($form == 'teamFocus') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'training_id' => ['required'],
                            'program' => ['required'],
                            'rol' => ['required'],
                            'member_DNI' => [
                                'required',
                                Rule::unique('fyl_training_team')->where(function ($query) use ($request) {
                                    return $query->where('training_id', $request->input('training_id'))
                                        ->where('program', $request->input('program'))
                                        ->where('rol', $request->input('rol'))
                                        ->where('member_DNI', $request->input('member_DNI'));
                                })
                            ]
                        ],
                        $customMessages = [
                            'rol.required' => 'Rol requerido',
                            'member_DNI.required' => 'Miembro requerido',
                            'member_DNI.unique' => 'El Miembro ya se encuentra registrado.'
                        ]

                    );
                }

                break;
            case 3:
                session()->flash('tab', 3);
                session()->flash('form', $form);
                if ($form == 'fechaYour') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'start_date_your' => ['required', 'date'],
                            'end_date_your' => ['required', 'date', 'after_or_equal:start_date_your']
                        ],
                        $customMessages = [
                            'start_date_your.required' => 'Fecha requerida',
                            'start_date_your.date' => 'Ingrese una fecha',
                            'end_date_your.required' => 'Fecha requerida',
                            'end_date_your.date' => 'Ingrese una fecha',
                            'after' => 'Fin debe ser mayor que Inicio',
                        ]
                    );
                }

                if ($form == 'teamYour') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'training_id' => ['required'],
                            'program' => ['required'],
                            'rol' => ['required'],
                            'member_DNI' => [
                                'required',
                                Rule::unique('fyl_training_team')->where(function ($query) use ($request) {
                                    return $query->where('training_id', $request->input('training_id'))
                                        ->where('program', $request->input('program'))
                                        ->where('rol', $request->input('rol'))
                                        ->where('member_DNI', $request->input('member_DNI'));
                                })
                            ]
                        ],
                        $customMessages = [
                            'rol.required' => 'Rol requerido',
                            'member_DNI.required' => 'Miembro requerido',
                            'member_DNI.unique' => 'El Miembro ya se encuentra registrado.'
                        ]

                    );
                }

                break;

            case 7:
                session()->flash('tab', 7);
                session()->flash('form', $form);
                if ($form == 'fechaLife') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'start_date_life' => ['required', 'date'],
                            'end_date_life' => ['required', 'date', 'after_or_equal:start_date_life']
                        ],
                        $customMessages = [
                            'start_date_life.required' => 'Fecha requerida',
                            'start_date_life.date' => 'Ingrese una fecha',
                            'end_date_life.required' => 'Fecha requerida',
                            'end_date_life.date' => 'Ingrese una fecha',
                            'after' => 'Fin debe ser mayor que Inicio',
                        ]
                    );
                }

                if ($form == 'teamLife') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'training_id' => ['required'],
                            'program' => ['required'],
                            'rol' => ['required'],
                            'member_DNI' => [
                                'required',
                                Rule::unique('fyl_training_team')->where(function ($query) use ($request) {
                                    return $query->where('training_id', $request->input('training_id'))
                                        ->where('program', $request->input('program'))
                                        ->where('rol', $request->input('rol'))
                                        ->where('member_DNI', $request->input('member_DNI'));
                                })
                            ]
                        ],
                        $customMessages = [
                            'rol.required' => 'Rol requerido',
                            'member_DNI.required' => 'Miembro requerido',
                            'member_DNI.unique' => 'El Miembro ya se encuentra registrado.'
                        ]

                    );
                }

                break;
            case 5:
                session()->flash('tab', 5);
                $validator = Validator::make(
                    $request->all(),
                    [
                        'team_name' => ['required'],
                        'team_motto' => ['required']
                    ],
                    $customMessages = [
                        'team_name.required' => 'Nombre de equipo requerido',
                        'team_motto.required' => 'Lema de equipo requerido',
                    ]
                );

                break;
            case 6:
                session()->flash('tab', 6);
                session()->flash('form', $form);
                if ($form == 'directory') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'team_directory' => ['required', 'mimes:pdf', 'mimetypes:application/pdf']
                        ],
                        $customMessages = [
                            'team_directory.required' => 'Foto requerida',
                            'team_directory.mimes' => 'El directorio debe ser un PDF',
                        ]
                    );
                }
                if ($form == 'photo') {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'team_photo' => ['required', 'image'],
                        ],
                        $customMessages = [
                            'team_photo.required' => 'Foto requerida',
                            'team_photo.image' => 'La Foto debe ser una imagen',
                        ]
                    );
                }

                break;
            default:
                // Acción predeterminada si el tipo no coincide con ninguno de los casos anteriores
                return response()->json(['error' => 'Tipo de solicitud no válido'], 400);
        }


        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator);
        }

        $data = $request->except(['_token', 'tagName', '_method', 'form']) + ['user_id' => auth()->id()];

        switch ($tagName) {
            case 1:
                $campus_name = Campus::where('id', $request->campus_id)->value('name');
                $data = $data + ['entrenamiento' => $campus_name . ' FYL - ' . $request->number];
                $Training->update($data);
                break;
            case 2:
                session()->flash('tab', 2);
                session()->flash('form', $form);

                if ($form == 'fechaFocus') {
                    $Training->update($data);
                }
                if ($form == 'teamFocus') {
                    TrainingTeam::create($data);
                }

                break;
            case 3:
                session()->flash('tab', 3);
                session()->flash('form', $form);
                if ($form == 'fechaYour') {
                    $Training->update($data);
                }
                if ($form == 'teamYour') {
                    TrainingTeam::create($data);
                }

                break;
            case 7:
                session()->flash('tab', 7);
                session()->flash('form', $form);
                if ($form == 'fechaLife') {
                    $Training->update($data);
                }
                if ($form == 'teamLife') {
                    TrainingTeam::create($data);
                }

                break;
            case 5:
                session()->flash('tab', 5);

                $Training->update($data);

                break;
            case 6:
                session()->flash('tab', 6);
                session()->flash('form', $form);
                if ($form == 'directory') {
                    if ($request->hasFile('team_directory')) {

                        $data['team_directory'] = $request->file('team_directory')->store('public');
                    }
                }
                if ($form == 'photo') {
                    if ($request->hasFile('team_photo')) {

                        $data['team_photo'] = $request->file('team_photo')->store('public');

                        $photoPath = $Training->team_photo;
                        if (str_contains($photoPath, 'default')) {
                            // El $photoPath contiene 'default'
                            // No es necesario eliminarlo porque es la imagen por defecto
                        } else {
                            // El $photoPath no contiene 'default'
                            // Puedes proceder a eliminar la imagen
                            Storage::delete($photoPath);
                        }
                    }
                }
                if ($form == 'deletePhoto') {
                    $data['team_photo'] = 'default.png';
                    $photoPath = $Training->team_photo;
                    Storage::delete($photoPath);
                }

                if ($form == 'deleteDirectory') {
                    $data['team_directory'] = null;
                    $directoryPath = $Training->team_directory;
                    Storage::delete($directoryPath);
                }
                $Training->update($data);

                break;
            default:
                // Acción predeterminada si el tipo no coincide con ninguno de los casos anteriores
                return response()->json(['error' => 'Tipo de solicitud no válido d'], 400);
        }

        $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');
        //$programs = Programs::orderBy('life_stage','ASC')->orderBy('level','ASC')->where('status','=','ACTIVE')->pluck('name','id');

        $focusTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $Training->id)
            ->where('program', 'Focus')->get();

        $yourTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $Training->id)
            ->where('program', 'Your')->get();


        $lifeTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $Training->id)
            ->where('program', 'Life')->get();

        $Training = Training::findOrFail($id);

        //return $Training;

        return redirect()->back()->with([
            'training' => $Training,
            'campus' => $campus,
            'focusTeam' => $focusTeam,
            'yourTeam' => $yourTeam,
            'lifeTeam' => $lifeTeam
        ]);

        // return to_route('Training.index', $Training)->with('status','Training updated!');
    }

    public function calendarLife(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'training_id' => ['required'],
                'life_template_id' => ['required'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'start_hour' => ['required'],
                'end_hour' => ['required', 'after_or_equal:start_hour'],

            ],
            $customMessages = [
                'start_date.required' => 'Fecha requerida',
                'start_date.date' => 'Ingrese una fecha',
                'end_date.required' => 'Fecha requerida',
                'end_date.date' => 'Ingrese una fecha',
                'start_hour.required' => 'Hora requerida',
                'end_hour.required' => 'Hora requerida',
                'after_or_equal' => 'Inicio menor o igual que Fin',
            ]
        );

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $data = $request->except(['_token', 'tagName', '_method']) + ['user_id' => auth()->id()];

        $activity = LifeTemplate::where('id', $request->life_template_id)->value('activity');

        LifeCalendar::create($data + ['activity' => $activity, 'user_id' => auth()->id()]);

        $lifeCalendar = LifeCalendar::where('training_id', $request->training_id)
            ->orderBy('start_date', 'ASC')
            ->orderBy('end_date', 'ASC')
            ->orderBy('start_hour', 'ASC')
            ->orderBy('start_hour', 'ASC')
            ->get();

        session()->flash('tab', 4);

        return redirect()->back()->with(['lifeCalendar' => $lifeCalendar]);
    }

    public function destroy(Training $Training)
    {
        try {
            $Training->delete();
        } catch (Exception $e) {
            return to_route('Training.index')->with('errors', 'El Entrenamiento no puede ser eliminado.');
        }

        return to_route('Training.index')->with('status', __('Training deleted!'));
    }

    public function destroyFocusTeam($id)
    {
        try {

            session()->flash('tab', 2);
            $focusTeam = TrainingTeam::findOrFail($id);

            $focusTeam->delete();

            $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');

            $focusTeam = TrainingTeam::from('fyl_training_team as TT')
                ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
                ->select(
                    'TT.id',
                    'TT.rol',
                    'TT.member_DNI',
                    DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
                )
                ->where('TT.id', $focusTeam->id)
                ->where('program', 'Focus')->get();

            return redirect()->back()->with([
                'campus' => $campus,
                'focusTeam' => $focusTeam
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['teamFocus' => 'El registro no puede ser eliminado.' . $e->getMessage()]);
        }
    }

    public function destroyYourTeam($id)
    {
        try {

            session()->flash('tab', 3);
            $yourTeam = TrainingTeam::findOrFail($id);

            $yourTeam->delete();

            $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');

            $yourTeam = TrainingTeam::from('fyl_training_team as TT')
                ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
                ->select(
                    'TT.id',
                    'TT.rol',
                    'TT.member_DNI',
                    DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
                )
                ->where('TT.id', $yourTeam->id)
                ->where('program', 'Your')->get();

            return redirect()->back()->with([
                'campus' => $campus,
                'yourTeam' => $yourTeam
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['teamYour' => 'El registro no puede ser eliminado.' . $e->getMessage()]);
        }
    }


    public function destroyLifeTeam($id)
    {
        try {

            session()->flash('tab', 7);
            $lifeTeam = TrainingTeam::findOrFail($id);

            $lifeTeam->delete();

            $campus = Campus::orderBy('name', 'ASC')->where('status', '=', 'ACTIVE')->pluck('name', 'id');

            $lifeTeam = TrainingTeam::from('fyl_training_team as TT')
                ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
                ->select(
                    'TT.id',
                    'TT.rol',
                    'TT.member_DNI',
                    DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
                )
                ->where('TT.id', $lifeTeam->id)
                ->where('program', 'Life')->get();

            return redirect()->back()->with([
                'campus' => $campus,
                'lifeTeam' => $lifeTeam
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['teamYour' => 'El registro no puede ser eliminado.' . $e->getMessage()]);
        }
    }

    public function destroyCalendar($id)
    {
        try {

            session()->flash('tab', 4);

            $lifeCalendar = LifeCalendar::findOrFail($id);
            $training_id = LifeCalendar::where('id', $id)->value('training_id');

            $lifeCalendar->delete();

            $lifeCalendar = LifeCalendar::where('training_id', $training_id)
                ->orderBy('start_date', 'ASC')
                ->orderBy('end_date', 'ASC')
                ->orderBy('start_hour', 'ASC')
                ->orderBy('start_hour', 'ASC')
                ->get();


            return redirect()->back()->with([
                'lifeCalendar' => $lifeCalendar,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['teamYour' => 'El registro no puede ser eliminado.' . $e->getMessage()]);
        }
    }

    public function findRolTraining($parametro)
    {
        $member = Employee::from('th_employees as E')
            ->join('th_job_title as JT', 'E.job_title_id', '=', 'JT.ID')
            ->select(
                'E.DNI',
                DB::raw("CONCAT(E.names,' ',E.surnames )  as name")
            )
            ->orderBy('E.surnames', 'ASC')->where('job_title_id', '=', $parametro)->get();

        return $member;
    }
    
    

    public function oldTeam()
    {
        $userId = auth()->id();
        $campus = DB::select('CALL fyl_get_campus_user(?)', [$userId]);

        $training = DB::select('CALL fyl_get_training_user(?)', [$userId]);

        return view('fyl/training/old_team', ['campus' => $campus, 'training' => $training]);
    }


    public function oldTeamRegister(Request $request)
    {
        $action = $request->action;
        $campusId = $request->campus_id;
        $number = 0;
        $teamName = $request->team_name;
        $status = $request->status;
        $userId = auth()->id();

        $validator = Validator::make($request->all(), [
            'action' => ['required'],
            'campus_id' => ['required'],
            'team_name' => ['required'],
            'status' => ['required']
        ]);
        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'campus_id' => $campusId,
            'number' => $number,
            'team_name' => $teamName,
            'status' => $status,
            'user_id' => $userId,
        ];

        if ($action == 0) {
            Training::create($data);
        } else {
            $trainingId = Training::where('id', $action)->first();
            $trainingId->update($data);
        }

        $campus = DB::select('CALL fyl_get_campus_user(?)', [$userId]);

        $training = DB::select('CALL fyl_get_training_user(?)', [$userId]);

        return view('fyl/training/old_team', ['campus' => $campus, 'training' => $training]);
    }
    
    public function findTrainingForCampus($campus_id,$training_id)
    {
        if($training_id === 0)
            return DB::table('fyl_next_life_view')->where('campus_id',$campus_id)->get();
        else
        {
            $training_in_game = DB::table('fyl_training_view')->where('id',$training_id);
            $trainings = DB::table('fyl_next_life_view')->where('campus_id',$campus_id);

            return $training_in_game->union($trainings)->get();

        }

    }
}
