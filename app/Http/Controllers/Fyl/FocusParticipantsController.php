<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveFocusParticipantsRequest;
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

class FocusParticipantsController extends Controller
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
        
        $search = $request->input('search') ?: '';

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);
        

         $training = DB::table('fyl_training_focus_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');

    //return $training;

        if (empty($requestData)) {
            return view('fyl/focusParticipants.index', [
                'training' => $training,
                'trainingId' => 0,
                'trainingIdEnroller' => 0,
                'mode' => '',
            ]);
        } else {
            
            $trainingId = $request->training_id;

            $position = $request->position;

            $trainingIdEnroller = $request->input('training_id_enroller') ?: '0';
            
            $call_B = $request->input('call_B') ?: '%';
            $call_L = $request->input('call_L') ?: '%';
            $perfil = $request->input('perfil') ?: '%';
            $mode = $request->input('mode') ?: '%';
            
            //return $trainingIdEnroller;

            $focusParticipants = DB::select('CALL get_fyl_focus_participants(?,?,?,?,?,?,?)', [$trainingId, $trainingIdEnroller, $search, $call_B, $call_L,$perfil,$mode]);
            $contador = 1;

            foreach ($focusParticipants as $focusParticipantsItem) {
                $focusParticipantsItem->secuencial = $contador;
                $contador++;
            }
            
            $distinctTrainings = DB::table('fyl_team_enroller_for_training')->where('training_id', $trainingId)->orderBy('name','ASC')->pluck('name','id');
            

            $follow_welcome = DB::select('CALL get_follow_focus_welcome(?)', [$trainingId]);
            
            $follow_logistics = DB::select('CALL get_follow_focus_logistics(?)', [$trainingId]);

            $ejecutivo_welcome = array_filter($follow_welcome, function ($item) {
                return $item->reporte === 'ejecutivo';
            });

            $equipo_welcome = array_filter($follow_welcome, function ($item) {
                return $item->reporte === 'equipo';
            });

            $resumen_welcome = array_filter($follow_welcome, function ($item) {
                return $item->reporte === 'resumen';
            });
            
            $ejecutivo_welcomeR = array_filter($follow_welcome, function ($item) {
                return $item->reporte === 'ejecutivo R';
            });

            $equipo_welcomeR = array_filter($follow_welcome, function ($item) {
                return $item->reporte === 'equipo R';
            });

            $resumen_welcomeR = array_filter($follow_welcome, function ($item) {
                return $item->reporte === 'resumen R';
            });

            $ejecutivo_logistics = array_filter($follow_logistics, function ($item) {
                return $item->reporte === 'ejecutivo';
            });

            $equipo_logistics = array_filter($follow_logistics, function ($item) {
                return $item->reporte === 'equipo';
            });

            $resumen_logistics = array_filter($follow_logistics, function ($item) {
                return $item->reporte === 'resumen';
            });
            
            $ejecutivo_logisticsR = array_filter($follow_logistics, function ($item) {
                return $item->reporte === 'ejecutivo R';
            });

            $equipo_logisticsR = array_filter($follow_logistics, function ($item) {
                return $item->reporte === 'equipo R';
            });

            $resumen_logisticsR = array_filter($follow_logistics, function ($item) {
                return $item->reporte === 'resumen R';
            });

            $data = [
                'trainingId' => $trainingId,
                'training' => $training,
                'focusParticipants' => $focusParticipants,
                
                'ejecutivo_welcome' => $ejecutivo_welcome,
                'equipo_welcome' => $equipo_welcome,
                'resumen_welcome' => $resumen_welcome,
                
                'ejecutivo_welcomeR' => $ejecutivo_welcomeR,
                'equipo_welcomeR' => $equipo_welcomeR,
                'resumen_welcomeR' => $resumen_welcomeR,
                
                'ejecutivo_logistics' => $ejecutivo_logistics,
                'equipo_logistics' => $equipo_logistics,
                'resumen_logistics' => $resumen_logistics,
                
                'ejecutivo_logisticsR' => $ejecutivo_logisticsR,
                'equipo_logisticsR' => $equipo_logisticsR,
                'resumen_logisticsR' => $resumen_logisticsR,
                
                'follow' => $follow_welcome,
                
                'call_id_B' => $call_B,
                'call_id_L' => $call_L,
                'call_B' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
                'call_L' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
                'participantsFocus' => new FocusParticipants(),
                
                'distinctTrainings' => $distinctTrainings,
                'trainingIdEnroller' => $trainingIdEnroller,
                'mode' => $mode,
            ];
            return view('fyl/focusParticipants.index', $data);
        }

    }

    public function ordenarDatos(Request $request)
    {
        $column = $request->input('column');
        $order = $request->input('order');

        $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
            ->join('fyl_training as T', 'FP.training_id', '=', 'T.id')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_training as TI', 'P.training_id', '=', 'TI.id')
            ->leftjoin('fyl_campus as CI', 'TI.campus_id', '=', 'CI.id')
            ->leftjoin('fyl_participants as PE', 'P.DNI_enroller', '=', 'PE.DNI')
            ->leftjoin('fyl_training as TE', 'PE.training_id', '=', 'TE.id')
            ->leftjoin('fyl_participants as PS', 'FP.staff_DNI', '=', 'PS.DNI')
            ->select(
                'FP.id',
                'FP.training_id',
                'FP.record_mode',
                'FP.participant_DNI',
                'FP.staff_DNI',
                'FP.attendance_status',
                'FP.statement',
                // 'FP.follow_up',
                // 'FP.logistics',
                'FP.attendance_status',
                'P.training_id as training_id_invited',
                'P.surnames',
                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                DB::raw("CONCAT(PS.names,' ',PS.surnames)  as staff"),
                DB::raw("CONCAT(C.name,' ',T.number)  as training"),
                DB::raw("(SELECT COUNT(*) FROM fyl_follow_focus AS Detail WHERE Detail.training_id = FP.training_id AND Detail.program_id = 2 AND Detail.participant_DNI = FP.participant_DNI) as calls"),
                DB::raw("(SELECT date_call FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI order by date_call desc, created_at desc  limit 1) as end_call"),
                DB::raw("(SELECT confirm_assistance FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI order by date_call desc, created_at desc  limit 1) as confirm_assistance"),
                'T.team_name',
                'P.nickname',
                'P.phone',
                'TE.team_name as team_enroller',
                DB::raw("CONCAT(CI.name,' FYL ',TI.number)  as number_focus"),
                DB::raw("CONCAT(PE.surnames,' ',PE.names)  as enroller"),
                'PE.phone as enroller_phone'
            )
            ->where('FP.training_id', 5)
            ->orderBy($column, $order)
            ->get();

        $contador = 1;

        foreach ($focusParticipants as $focusParticipantsItem) {
            $focusParticipantsItem->secuencial = $contador;
            $contador++;
        }

        return view('fyl/focusParticipants.index', compact('focusParticipants'));

        return ['datos' => $focusParticipants];
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

        return view('fyl/focusParticipants/create', [
            'city' => $city,
            'focusParticipants' => new FocusParticipants
        ]);
    }
    public function store(Request $request)
    {

        $trainingId = $request->training_id;
        $userId = auth()->id();

        DB::select('CALL insert_focus_participants1(?,?)', [$trainingId,$userId]);

        $trainings = $this->getTrainings();

        $search = session('search');

        $focusParticipants = $this->getFocusParticipants($trainingId,"");
        $follow = $this->getFollow($trainingId);

        $participantsFocus = FocusParticipants::where('training_id', $trainingId)->get();

        return to_route('FocusParticipants.index',['training_id'=>$trainingId])->with('status','Campus updated!');

        return view('fyl/focusParticipants.index', [
             'trainingId' => [
                'trainingId' => $request->training_id,
            ],
        ]);
    }

    public function left_over(Request $request)
    {
        //return $request;
        $trainingId = $request->training_id;
        $DNI = $request->dni_resagado;
        $userId = auth()->id();

        DB::select('CALL insert_focus_participants_left_over(?,?,?)', [$trainingId,$DNI, $userId]);

        //$resagados = DB::table('fyl_late_participants_view')->pluck('name','id');
        $resagados = DB::table('fyl_late_participants_view')->where('training_id','<>',$request->training_id)->pluck('name','id');

        return to_route('FocusParticipants.index',[
            'training_id' => $trainingId,
            'resagados' => $trainingId,
            ])->with('status', 'Campus updated!');

        return view('fyl/focusParticipants.index', [
            'trainingId' => ['trainingId' => $request->resagados],
        ]);
    }

    private function getFieldTraining($campusId, $number)
    {
        $lowerLimit = $number - 3;
        $upperLimit = $number;

        return Training::where('campus_id', $campusId)
            ->whereBetween('number', [$lowerLimit, $upperLimit])
            ->pluck('id');
    }

    private function getParticipantsNormal($trainingId)
    {
        return Participants::where('training_id', $trainingId)
            ->where('payment_status_focus', 'PAGO TOTAL')
            ->where('id', '>', 138)
            ->whereNotIn('id', [244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256])
            ->whereNotNull('training_id')
            ->whereNotIn('DNI', function ($query) {
                $query->select('participant_DNI')
                    ->from('fyl_focus_participants')
                    ->where('attendance_status', 'ASISTIÓ');
            })
            ->get();
    }

    private function getParticipantsRecuperado($fieldTraining, $currentNormalParticipantsDNI)
    {
        return Participants::whereIn('training_id', $fieldTraining)
            ->where('payment_status_focus', 'PAGO TOTAL')
            ->where('id', '>', 138)
            ->whereNotIn('id', [244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256])
            ->whereNotNull('training_id')
            ->whereNotIn('DNI', $currentNormalParticipantsDNI)
            ->whereNotIn('DNI', function ($query) {
                $query->select('participant_DNI')
                    ->from('fyl_focus_participants')
                    ->where('attendance_status', 'ASISTIÓ');
            })
            ->get();
    }

    private function getParticipantsResagado($currentNormalParticipantsDNI, $currentRecuperadoParticipantsDNI)
    {
        return Participants::whereNotIn('DNI', $currentNormalParticipantsDNI)
            ->where('payment_status_focus', 'PAGO TOTAL')
            ->where('id', '>', 138)
            ->whereNotIn('id', [244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256])
            ->whereNotNull('training_id')
            ->whereNotIn('DNI', $currentRecuperadoParticipantsDNI)
            ->whereNotIn('DNI', function ($query) {
                $query->select('participant_DNI')
                    ->from('fyl_focus_participants')
                    ->where('attendance_status', 'ASISTIÓ');
            })
            ->get();
    }

    private function insertDuplicateData($participants, $currentParticipantsDNI, $training, $record)
    {
        $existingEntries = FocusParticipants::whereIn('participant_DNI', $currentParticipantsDNI)
            ->where('training_id', $training->id)
            ->pluck('participant_DNI')
            ->toArray();

        $duplicateData = [];

        foreach ($participants as $participant) {
            if (!in_array($participant->DNI, $existingEntries)) {
                $duplicateData[] = [
                    'training_id' => $training->id,
                    'record_mode' => $record,
                    'participant_DNI' => $participant->DNI,
                    'attendance_status' => 'NO ASISTIÓ',
                    'user_id' => auth()->id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $existingEntries[] = $participant->DNI;
            }
        }

        if (!empty($duplicateData)) {
            FocusParticipants::insert($duplicateData);
        }
    }

    private function getTrainings()
    {
        return DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join(DB::raw('(select campus_id, min(start_date_focus) start_date_focus
                            from fyl_training T
                            where start_date_focus is not null
                            and start_date_focus > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                            group by campus_id) as F'), function ($join) {
                $join->on('C.id', '=', 'F.campus_id')
                    ->whereColumn('T.start_date_focus', '=', 'F.start_date_focus');
            })
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->pluck('name', 'id');
    }

    private function getFocusParticipants($trainingId,$search)
    {
        $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
            ->join('fyl_training as T', 'FP.training_id', '=', 'T.id')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_training as TI', 'P.training_id', '=', 'TI.id')
            ->leftjoin('fyl_campus as CI', 'TI.campus_id', '=', 'CI.id')
            ->leftjoin('fyl_participants as PE', 'P.DNI_enroller', '=', 'PE.DNI')
            ->leftjoin('fyl_training as TE', 'PE.training_id', '=', 'TE.id')
            ->leftjoin('fyl_participants as PS', 'FP.staff_DNI', '=', 'PS.DNI')
            ->select(
                'FP.id',
                'FP.training_id',
                'FP.record_mode',
                'FP.participant_DNI',
                'FP.staff_DNI',
                'FP.attendance_status',
                // 'FP.follow_up',
                // 'FP.logistics',
                'FP.attendance_status',
                'P.training_id as training_id_invited',
                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                DB::raw("CONCAT(PS.names,' ',PS.surnames)  as staff"),
                DB::raw("CONCAT(C.name,' ',T.number)  as training"),


                DB::raw("(SELECT COUNT(*) FROM fyl_follow_focus AS Detail WHERE Detail.training_id = FP.training_id AND Detail.program_id = 2 AND Detail.participant_DNI = FP.participant_DNI AND type_call = 'Bienvenida') as welcome"),
                DB::raw("(SELECT name FROM users WHERE id = (SELECT user_id FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI AND type_call = 'Bienvenida' order by date_call desc, created_at desc  limit 1)) as user_welcome"),
                DB::raw("(SELECT date_call FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI AND type_call = 'Bienvenida' order by date_call desc, created_at desc  limit 1) as end_call_welcome"),
                DB::raw("(SELECT confirm_assistance FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI AND type_call = 'Bienvenida' order by date_call desc, created_at desc  limit 1) as confirm_assistance_welcome"),

                DB::raw("(SELECT COUNT(*) FROM fyl_follow_focus AS Detail WHERE Detail.training_id = FP.training_id AND Detail.program_id = 2 AND Detail.participant_DNI = FP.participant_DNI AND type_call = 'Logistica') as logistcs"),
                DB::raw("(SELECT name FROM users WHERE id = (SELECT user_id FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI AND type_call = 'Logistica' order by date_call desc, created_at desc  limit 1)) as user_logistcs"),
                DB::raw("(SELECT date_call FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI AND type_call = 'Logistica' order by date_call desc, created_at desc  limit 1) as end_call_logistcs"),
                DB::raw("(SELECT confirm_assistance FROM fyl_follow_focus WHERE training_id = FP.training_id AND program_id = 2 AND participant_DNI = FP.participant_DNI AND type_call = 'Logistica' order by date_call desc, created_at desc  limit 1) as confirm_assistance_logistcs"),
                'T.team_name',
                'P.nickname',
                'P.phone',
                'TE.team_name as team_enroller',
                DB::raw("CONCAT(CI.name,' FYL ',TI.number)  as number_focus"),
                DB::raw("CONCAT(PE.surnames,' ',PE.names)  as enroller"),
                'PE.phone as enroller_phone'
            )
            ->where(function ($query) use ($search) {
                $query->where('P.names', 'LIKE', '%' . $search . '%')
                    ->orWhere('P.surnames', 'LIKE', '%' . $search . '%')
                    ->orWhere('P.phone', 'LIKE', '%' . $search . '%');
            })
            ->where('FP.training_id', $trainingId)
            ->orderBy('FP.record_mode','asc')
            ->orderBy('TE.team_name','asc')
            ->orderBy('P.surnames','asc')
            ->orderBy('P.names','asc')
            ->get();

            //return $focusParticipants;

        $contador = 1;

        foreach ($focusParticipants as $focusParticipantsItem) {
            $focusParticipantsItem->secuencial = $contador;
            $contador++;
        }

        return $focusParticipants;
    }

    private function getFollow($trainingId)
    {
        return DB::table('fyl_follow_focus')
            ->select('confirm_assistance', DB::raw('COUNT(*) as CANTIDAD'))
            ->where('training_id', $trainingId)
            ->groupBy('confirm_assistance')
            ->orderByDesc('confirm_assistance')
            ->get();

       
    }



    public function show(Request $request)
    {
        return 'Hola';
        //return view('fyl/focusParticipants/show', ['focusParticipants' => $focusParticipants]);
    }

    public function edit($id)
    {

        $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
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

return $focusParticipants;

        $followUp = FollowFocus::from('fyl_follow_focus as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select('FF.date_call',
                    'FF.confirm_assistance',
                    'FF.summary_call',
                    'U.name',
                    'FF.created_at')
            ->where('program_id', 2)
            ->where('participant_DNI', $focusParticipants->participant_DNI)
            ->where('training_id', $focusParticipants->training_id)->get();

        return view('fyl/focusParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'focusParticipants' => $focusParticipants
        ]);
    }

    public function call(Request $request)
    {

        //return $request;
        $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_participants as PE', 'FP.DNI_enroller', '=', 'PE.DNI')
            ->leftjoin('th_employees as E', 'FP.DNI_enroller', '=', 'E.DNI')
            ->select(
                'FP.id',
                'FP.participant_DNI',
                'FP.training_id',
                'FP.training_id_enroller',
                'FP.record_mode',
                'P.names',
                'P.surnames',
                'P.phone',
                'P.phone2',
                'P.nickname',
                'P.city_of_residenceT',
                DB::raw("COALESCE(CONCAT(PE.names,' ',PE.surnames),CONCAT(E.names,' ',E.surnames))  as enroller"),
                DB::raw("COALESCE(PE.phone,E.phone) as enroller_phone")
            )
            ->where('FP.id', $request->id)
            ->first();
            
           // return $focusParticipants;

        if ($focusParticipants) {
            $consulta = DB::table('fyl_follow_focus as ff1')
                ->select('user_id', 'confirm_assistance', 'user_id')
                ->addSelect(DB::raw("(SELECT COUNT(*) FROM fyl_follow_focus WHERE training_id = $focusParticipants->training_id AND participant_DNI = $focusParticipants->participant_DNI AND type_call = '$request->type_call') AS cant"))
                ->where('id', function ($query) use ($focusParticipants, $request) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('fyl_follow_focus as ff2')
                        ->where('training_id', $focusParticipants->training_id)
                        ->where('participant_DNI', $focusParticipants->participant_DNI)
                        ->where('type_call', $request->type_call);
                })
                ->first();

            if ($consulta) {
                if($request->type_call == 'Bienvenida') {
                    $focusParticipants->update([
                        'confirm_assistance_b' => $consulta->confirm_assistance,
                        'user_id_call_b' => $consulta->user_id,
                        'calls_b' => $consulta->cant
                    ]);
                }
                else{
                    $focusParticipants->update([
                        'confirm_assistance_l' => $consulta->confirm_assistance,
                        'user_id_call_l' => $consulta->user_id,
                        'calls_l' => $consulta->cant
                    ]);
                }

            }
        }

        $followUp = FollowFocus::from('fyl_follow_focus as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select(
                'FF.date_call',
                'FF.type_call',
                'FF.confirm_assistance',
                'FF.summary_call',
                'U.name',
                'FF.created_at'
            )
            ->where('program_id', 2)
            ->where('participant_DNI', $focusParticipants->participant_DNI)
            ->where('training_id', $focusParticipants->training_id)->get();

            //return $focusParticipants;

        return view('fyl/focusParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'focusParticipants' => $focusParticipants,
            'type_call' => $request->type_call,
        ]);
    }

    public function update(Request $request, $id)
    {

            $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
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

            //return $request;
        
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

        $follow = [
            'training_id' => $request->input('training_id'),
            'program_id' => $request->input('program_id'),
            'type_call' => $request->input('type_call'),
            'participant_DNI' => $request->input('participant_DNI'),
            'date_call' => $request->input('date_call'),
            'confirm_assistance' => $request->input('confirm_assistance'),
            'summary_call' => $request->input('summary_call'),
            'user_id' => auth()->id()
        ];

        FollowFocus::create($follow);

        $consulta = DB::table('fyl_follow_focus as ff1')
                ->select('user_id', 'confirm_assistance', 'user_id')
                ->addSelect(DB::raw("(SELECT COUNT(*) FROM fyl_follow_focus WHERE training_id = $focusParticipants->training_id AND participant_DNI = $focusParticipants->participant_DNI AND type_call = '$request->type_call') AS cant"))
                ->where('id', function ($query) use ($focusParticipants, $request) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('fyl_follow_focus as ff2')
                        ->where('training_id', $focusParticipants->training_id)
                        ->where('participant_DNI', $focusParticipants->participant_DNI)
                        ->where('type_call', $request->type_call);
                })
                ->first();

            if ($consulta) {
                if($request->type_call == 'Bienvenida') {
                    $focusParticipants->update([
                        'confirm_assistance_b' => $consulta->confirm_assistance,
                        'user_id_call_b' => $consulta->user_id,
                        'calls_b' => $consulta->cant
                    ]);
                }
                else{
                    $focusParticipants->update([
                        'confirm_assistance_l' => $consulta->confirm_assistance,
                        'user_id_call_l' => $consulta->user_id,
                        'calls_l' => $consulta->cant
                    ]);
                }
            }

        $followUp = FollowFocus::from('fyl_follow_focus as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select(
                'FF.date_call',
                'FF.confirm_assistance',
                'FF.type_call',
                'FF.summary_call',
                'U.name',
                'FF.created_at'
            )
            ->where('program_id', 2)
            ->where('participant_DNI', $focusParticipants->participant_DNI)
            ->where('training_id', $focusParticipants->training_id)->get();

        return view('fyl/focusParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'focusParticipants' => $focusParticipants,
            'type_call' => $request->type_call
        ]);

    }

    public function destroy(FocusParticipants $focusParticipants)
    {
        try {
            $focusParticipants->delete();
        } catch (Exception $e) {
            return to_route('FocusParticipants.index')->with('errors', 'La Sede no puede ser eliminada.');
        }

        return to_route('FocusParticipants.index')->with('status', __('FocusParticipants deleted!'));
    }

    public function team(Request $request)
    {
        $requestData = $request->all();

        $training = DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join(DB::raw('(select campus_id, min(start_date_focus) start_date_focus
                    from fyl_training T
                    where start_date_focus is not null
                    and start_date_focus > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                    group by campus_id) as F'), function ($join) {
                $join->on('C.id', '=', 'F.campus_id')
                    ->whereColumn('T.start_date_focus', '=', 'F.start_date_focus');
            })
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->pluck('name', 'id');



        $focusTeamEmpty = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', 999999999)
            ->where('program', 'Focus')->get();

        $focusParticipantsEmpty = FocusParticipants::from('fyl_focus_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->select(
                'FP.id',
                'FP.training_id',
                'FP.record_mode',
                'FP.participant_DNI',
                'FP.staff_DNI',
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

        $focusTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $request->training_id)
            ->where('program', 'Focus')->get();

        $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->select(
                'FP.id',
                'FP.training_id',
                'FP.record_mode',
                'FP.participant_DNI',
                'FP.staff_DNI',
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

        //return $focusTeam;

        if (empty($requestData)) {
            return view('fyl/focusParticipants.team', [
                'training' => $training,
                'focusTeam' =>  $focusTeamEmpty,
                'focusParticipants' => $focusParticipantsEmpty,
            ]);
        } else {
            return view('fyl/focusParticipants.team', [
                'training' => $training,
                'focusTeam' =>  $focusTeam,
                'focusParticipants' => $focusParticipants,
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $newStatus = $request->input('attendance_status');
        $day = $request->input('attendance_day');

        $focusParticipants = FocusParticipants::find($id);


        if ($focusParticipants) {
            
            if ($day == 'friday') {
                $focusParticipants->friday_attended = $newStatus;
                $focusParticipants->saturday_attended = $newStatus;
                $focusParticipants->sunday_attended = $newStatus;
            }
            if ($day == 'saturday') {
                $focusParticipants->saturday_attended = $newStatus;
                $focusParticipants->sunday_attended = $newStatus;
            }
            if ($day == 'sunday') {
                $focusParticipants->sunday_attended = $newStatus;
            }
            $focusParticipants->save();
            
        }
        return to_route('FocusParticipants.index');
    }
    
    function agregaOtraSede(Request $request)
    {
        try {
            
            $DNI = $request->DNI;
            $trainingId = $request->trainingId;
            $userId = auth()->id();
            
            DB::select('CALL sp_inserta_focus_other_campus(?,?,?)', [$trainingId, $DNI,$userId] );
            
            return 'success';
            
        } catch (Exception $e) {
            return $e;
        }
        //return $request;
            
        
         
        
    }
}
