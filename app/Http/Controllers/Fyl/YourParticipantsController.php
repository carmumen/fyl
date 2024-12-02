<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Global\Catalog;
use App\Models\Fyl\YourParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Training;
use App\Models\Fyl\TrainingTeam;
use App\Models\Fyl\FollowYour;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Exception;

class YourParticipantsController extends Controller
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

        $training = DB::table('fyl_training_your_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');

        if (empty($requestData)) {
            return view('fyl/yourParticipants.index', [
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

            $yourParticipants = DB::select('CALL get_fyl_your_participants(?,?,?,?,?,?,?)', [$trainingId, $trainingIdEnroller, $search, $call_B, $call_L,$perfil,$mode]);
            $contador = 1;

            foreach ($yourParticipants as $yourParticipantsItem) {
                $yourParticipantsItem->secuencial = $contador;
                $contador++;
            }

            $distinctTrainings = DB::table('fyl_team_enroller_for_training_your')->where('training_id', $trainingId)->orderBy('name','ASC')->pluck('name','id');


            $follow_welcome = DB::select('CALL get_follow_your_welcome(?)', [$trainingId]);

            $follow_logistics = DB::select('CALL get_follow_your_logistics(?)', [$trainingId]);

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


            //$resagados = DB::table('fyl_late_participants_view')->pluck('name','id');
            $resagados = DB::table('fyl_late_participants_view')->where('training_id','<>',$request->training_id)->pluck('name','id');

            $data = [
                'trainingId' => $trainingId,
                'training' => $training,
                'yourParticipants' => $yourParticipants,

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
                //'follow' => $follow_logistics,
                'call_id_B' => $call_B,
                'call_id_L' => $call_L,
                'call_B' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
                'call_L' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
                'participantsYour' => new YourParticipants(),
                'resagados' => $resagados,
                'distinctTrainings' => $distinctTrainings,
                'trainingIdEnroller' => $trainingIdEnroller,
                'mode' => $mode,
            ];
            return view('fyl/yourParticipants.index', $data);
        }
    }

    public function get_training_next()
    {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next_your(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
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

        return view('fyl/yourParticipants/create', [
            'city' => $city,
            'yourParticipants' => new YourParticipants
        ]);
    }
    public function store(Request $request)
    {


        $trainingId = $request->training_id;
        $userId = auth()->id();

        DB::select('CALL insert_your_participants(?,?)', [$trainingId, $userId]);

        $call_B = '%';
        $call_L = '%';

        return to_route('YourParticipants.index', ['training_id' => $trainingId])->with('status', 'Campus updated!');

        return view('fyl/yourParticipants.index', [
            'trainingId' => ['trainingId' => $request->training_id],
        ]);
    }

    public function left_over(Request $request)
    {
       // return $request;
        $parts = explode('|', $request->input('dni_rezagado'));

        $training_id = $parts[0];
        $training_id_enroller = $parts[1];
        $DNI_enroller = $parts[2];
        $participant_DNI = $parts[3];
        $record_mode = $parts[4];
        $userId = auth()->id();

        DB::select('CALL insert_your_participants_left_over(?,?,?,?,?,?)', [
            $training_id,
            $training_id_enroller,
            $DNI_enroller,
            $participant_DNI,
            $record_mode,
            $userId]);

        return to_route('YourParticipants.index', [
            'training_id' => $training_id,
        ])->with('status', 'Campus updated!');

        return view('fyl/yourParticipants.index', [
            'trainingId' => ['trainingId' => $request->rezagados],
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
        return Participants::from('fyl_participants as P')
            ->where('payment_status_your', 'PAGO TOTAL')
            ->join('fyl_your_participants as FP', 'P.DNI', '=', 'FP.participant_DNI')
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->where('FP.training_id', $trainingId)
            ->whereNotIn('DNI', function ($query) {
                $query->select('participant_DNI')
                    ->from('fyl_your_participants')
                    ->where('attendance_status', 'ASISTIÓ');
            })
            ->get();
    }

    private function getParticipantsRecuperado($fieldTraining, $currentNormalParticipantsDNI)
    {
        return Participants::from('fyl_participants as P')
            ->where('payment_status_your', 'PAGO TOTAL')
            ->join('fyl_your_participants as FP', 'P.DNI', '=', 'FP.participant_DNI')
            ->whereIn('FP.training_id', $fieldTraining)
            ->whereNotIn('P.DNI', $currentNormalParticipantsDNI)
            ->whereNotIn('P.DNI', function ($query) {
                $query->select('participant_DNI')
                    ->from('fyl_your_participants')
                    ->where('attendance_status', 'ASISTIÓ');
            })
            ->get();
    }


    private function getParticipantsRezagado($currentNormalParticipantsDNI, $currentRecuperadoParticipantsDNI)
    {
        return Participants::from('fyl_participants as P')
            ->where('payment_status_your', 'PAGO TOTAL')
            ->join('fyl_your_participants as FP', 'P.DNI', '=', 'FP.participant_DNI')
            ->whereNotIn('P.DNI', $currentNormalParticipantsDNI)
            ->whereNotIn('P.DNI', $currentRecuperadoParticipantsDNI)
            ->whereNotIn('P.DNI', function ($query) {
                $query->select('participant_DNI')
                    ->from('fyl_your_participants')
                    ->where('attendance_status', 'ASISTIÓ');
            })
            ->get();
    }

    private function insertDuplicateData($participants, $currentParticipantsDNI, $training, $record)
    {
        $existingEntries = YourParticipants::whereIn('participant_DNI', $currentParticipantsDNI)
            ->where('training_id', $training->id)
            ->pluck('participant_DNI')
            ->toArray();

        $duplicateData = [];


        $fecha = date('Y-m-d H:i:s');

        foreach ($participants as $participant) {
            if (!in_array($participant->DNI, $existingEntries)) {
                $duplicateData[] = [
                    'training_id' => $training->id,
                    'record_mode' => $record,
                    'participant_DNI' => $participant->DNI,
                    'attendance_status' => 'NO ASISTIÓ',
                    'user_id' => auth()->id(),
                    'created_at' => $fecha,
                    'updated_at' => $fecha,
                ];

                $existingEntries[] = $participant->DNI;
            }
        }

        if (!empty($duplicateData)) {
            YourParticipants::insert($duplicateData);
        }
    }

    private function getTrainings()
    {
        return DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join(DB::raw('(select campus_id, min(start_date_your) start_date_your
                            from fyl_training T
                            where start_date_your is not null
                            and start_date_your > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                            group by campus_id) as F'), function ($join) {
                $join->on('C.id', '=', 'F.campus_id')
                    ->whereColumn('T.start_date_your', '=', 'F.start_date_your');
            })
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->pluck('name', 'id');
    }

    private function getYourParticipants($trainingId)
    {
        $yourParticipants = YourParticipants::from('fyl_your_participants as FP')
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
                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                DB::raw("CONCAT(PS.names,' ',PS.surnames)  as staff"),
                DB::raw("CONCAT(C.name,' ',T.number)  as training"),
                DB::raw("(SELECT COUNT(*) FROM fyl_follow_your AS Detail WHERE Detail.training_id = FP.training_id AND Detail.program_id = 3 AND Detail.participant_DNI = FP.participant_DNI) as calls"),
                DB::raw("(SELECT date_call FROM fyl_follow_your WHERE training_id = FP.training_id AND program_id = 3 AND participant_DNI = FP.participant_DNI order by date_call desc, created_at desc  limit 1) as end_call"),
                DB::raw("(SELECT confirm_assistance FROM fyl_follow_your WHERE training_id = FP.training_id AND program_id = 3 AND participant_DNI = FP.participant_DNI order by date_call desc, created_at desc  limit 1) as confirm_assistance"),
                'T.team_name',
                'P.nickname',
                'P.phone',
                'TE.team_name as team_enroller',
                DB::raw("CONCAT(CI.name,' FYL ',TI.number)  as number_your"),
                DB::raw("CONCAT(PE.surnames,' ',PE.names)  as enroller"),
                'PE.phone as enroller_phone'
            )
            ->where('FP.training_id', $trainingId)
            ->orderBy('TI.number', 'desc')
            ->orderBy('participant', 'asc')
            ->orderBy('FP.attendance_status', 'asc')
            ->get();

        $contador = 1;

        foreach ($yourParticipants as $yourParticipantsItem) {
            $yourParticipantsItem->secuencial = $contador;
            $contador++;
        }

        return $yourParticipants;
    }

    private function getFollow($trainingId)
    {
        return DB::table(function ($query) use ($trainingId) {
            $query->from('fyl_follow_your as FF')
                ->where('FF.program_id', 3)
                ->selectRaw('distinct participant_DNI')
                ->selectSub(function ($subquery) use ($trainingId) {
                    $subquery->from('fyl_follow_your as SubFF')
                        ->select('confirm_assistance')
                        ->whereRaw('SubFF.participant_DNI = FF.participant_DNI')
                        ->where('SubFF.training_id', $trainingId)
                        ->where('SubFF.program_id', 3)
                        ->orderByDesc('date_call')
                        ->orderByDesc('created_at')
                        ->limit(1);
                }, 'confirm_assistance');
        }, 'result')
            ->select('result.confirm_assistance', DB::raw('count(*) as CANTIDAD'))
            ->groupBy('result.confirm_assistance')
            ->get()
            ->toArray();
    }




    public function show($id)
    {
        return 'Hola';
        //return view('fyl/yourParticipants/show', ['yourParticipants' => $yourParticipants]);
    }

    public function edit($id)
    {
        $yourParticipants = YourParticipants::from('fyl_your_participants as FP')
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
                DB::raw("CONCAT(PE.names,' ',PE.surnames)  as enroller"),
                'PE.phone as enroller_phone'
            )
            ->where('FP.id', $id)
            ->first();
        // return $yourParticipants;

        $followUp = DB::table('fyl_follow_your as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select('FF.date_call',
                    'FF.confirm_assistance',
                    'FF.summary_call',
                    'U.name',
                    'FF.created_at')
            ->where('program_id', 3)
            ->where('participant_DNI', $yourParticipants->participant_DNI)
            ->where('training_id', $yourParticipants->training_id)->get();

        return view('fyl/yourParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'yourParticipants' => $yourParticipants
        ]);
    }

    public function call(Request $request)
    {
        $yourParticipants = YourParticipants::from('fyl_your_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_participants as PE', 'FP.DNI_enroller', '=', 'PE.DNI')
            ->leftjoin('th_employees as E', 'FP.DNI_enroller', '=', 'E.DNI')
            ->select(
                'FP.id',
                'FP.participant_DNI',
                'FP.training_id',
                'FP.training_id_enroller',
                'P.names',
                'P.surnames',
                'P.phone',
                'P.nickname',
                'P.city_of_residenceT',
                'P.payment_status_life',
                DB::raw("COALESCE(CONCAT(PE.names,' ',PE.surnames),CONCAT(E.names,' ',E.surnames))  as enroller"),
                DB::raw("COALESCE(PE.phone,E.phone) as enroller_phone"),
            )
            ->where('FP.id', $request->id)
            ->first();

        if ($yourParticipants) {
            $consulta = DB::table('fyl_follow_your as ff1')
                ->select('user_id', 'confirm_assistance', 'user_id')
                ->addSelect(DB::raw("(SELECT COUNT(*) FROM fyl_follow_your WHERE training_id = $yourParticipants->training_id AND participant_DNI = $yourParticipants->participant_DNI AND type_call = '$request->type_call') AS cant"))
                ->where('id', function ($query) use ($yourParticipants, $request) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('fyl_follow_your as ff2')
                        ->where('training_id', $yourParticipants->training_id)
                        ->where('participant_DNI', $yourParticipants->participant_DNI)
                        ->where('type_call', $request->type_call);
                })
                ->first();

            if ($consulta) {
                if ($request->type_call == 'Bienvenida') {
                    $yourParticipants->update([
                        'confirm_assistance_b' => $consulta->confirm_assistance,
                        'user_id_call_b' => $consulta->user_id,
                        'calls_b' => $consulta->cant
                    ]);
                } else {
                    $yourParticipants->update([
                        'confirm_assistance_l' => $consulta->confirm_assistance,
                        'user_id_call_l' => $consulta->user_id,
                        'calls_l' => $consulta->cant
                    ]);
                }
            }
        }

        $followUp = DB::table('fyl_follow_your as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select(
                'FF.id',
                'FF.date_call',
                'FF.type_call',
                'FF.confirm_assistance',
                'FF.summary_call',
                'U.name',
                'FF.created_at'
            )
            ->where('program_id', 3)
            ->where('participant_DNI', $yourParticipants->participant_DNI)
            ->where('training_id', $yourParticipants->training_id)
            ->orderBy('FF.id','desc')->get();

        return view('fyl/yourParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'yourParticipants' => $yourParticipants,
            'type_call' => $request->type_call
        ]);
    }

    public function update(Request $request, $id)
    {
        $yourParticipants = YourParticipants::from('fyl_your_participants as FP')
            ->join('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_participants as PE', 'FP.DNI_enroller', '=', 'PE.DNI')
            ->select(
                'FP.id',
                'FP.participant_DNI',
                'FP.training_id',
                'P.names',
                'P.surnames',
                'P.phone',
                'P.nickname',
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
            'summary_call' => ['required'],
        ]);

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
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

        FollowYour::create($follow);

        $consulta = DB::table('fyl_follow_your as ff1')
            ->select('user_id', 'confirm_assistance', 'user_id')
            ->addSelect(DB::raw("(SELECT COUNT(*) FROM fyl_follow_your WHERE training_id = $yourParticipants->training_id AND participant_DNI = $yourParticipants->participant_DNI AND type_call = '$request->type_call') AS cant"))
            ->where('id', function ($query) use ($yourParticipants, $request) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('fyl_follow_your as ff2')
                    ->where('training_id', $yourParticipants->training_id)
                    ->where('participant_DNI', $yourParticipants->participant_DNI)
                    ->where('type_call', $request->type_call);
            })
            ->first();

        if ($consulta) {
            if ($request->type_call == 'Bienvenida') {
                $yourParticipants->update([
                    'confirm_assistance_b' => $consulta->confirm_assistance,
                    'user_id_call_b' => $consulta->user_id,
                    'calls_b' => $consulta->cant
                ]);
            } else {
                $yourParticipants->update([
                    'confirm_assistance_l' => $consulta->confirm_assistance,
                    'user_id_call_l' => $consulta->user_id,
                    'calls_l' => $consulta->cant
                ]);
            }
        }

        $followUp = FollowYour::from('fyl_follow_your as FF')
            ->join('users as U', 'FF.user_id', '=', 'U.id')
            ->select(
                'FF.id',
                'FF.date_call',
                'FF.confirm_assistance',
                'FF.type_call',
                'FF.summary_call',
                'U.name',
                'FF.created_at'
            )
            ->where('program_id', 3)
            ->where('participant_DNI', $yourParticipants->participant_DNI)
            ->where('training_id', $yourParticipants->training_id)
            ->orderBy('FF.id','desc')->get();

        return view('fyl/yourParticipants/edit', [
            'call' => Catalog::where('catalog_types_id', 11)->pluck('name', 'acronym'),
            'followUp' => $followUp,
            'yourParticipants' => $yourParticipants,
            'type_call' => $request->type_call
        ]);
    }

    public function destroy(YourParticipants $yourParticipants)
    {
        try {
            $yourParticipants->delete();
            return to_route('YourParticipants.index')->with('status', __('YourParticipants deleted!'));
        } catch (Exception $e) {
            return to_route('YourParticipants.index')->with('errors', 'LA llamada no puede ser eliminada.');
        }
    }

    public function team(Request $request)
    {
        $requestData = $request->all();

        $training = DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join(DB::raw('(select campus_id, min(start_date_your) start_date_your
                    from fyl_training T
                    where start_date_your is not null
                    and start_date_your > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                    group by campus_id) as F'), function ($join) {
                $join->on('C.id', '=', 'F.campus_id')
                    ->whereColumn('T.start_date_your', '=', 'F.start_date_your');
            })
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->pluck('name', 'id');



        $yourTeamEmpty = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', 999999999)
            ->where('program', 'Your')->get();

        $yourParticipantsEmpty = yourParticipants::from('fyl_your_participants as FP')
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

        $yourTeam = TrainingTeam::from('fyl_training_team as TT')
            ->leftjoin('th_employees as E', 'E.DNI', '=', 'TT.member_DNI')
            ->leftjoin('th_job_title as JT', 'JT.id', '=', 'TT.rol')
            ->select(
                'TT.id',
                'JT.name as rol',
                'TT.member_DNI',
                DB::raw("(CONCAT(E.surnames,' ',E.names)) as names")
            )
            ->where('TT.training_id', $request->training_id)
            ->where('program', 'Your')->get();

        $yourParticipants = YourParticipants::from('fyl_your_participants as FP')
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

        //return $yourTeam;

        if (empty($requestData)) {
            return view('fyl/yourParticipants.team', [
                'training' => $training,
                'yourTeam' =>  $yourTeamEmpty,
                'yourParticipants' => $yourParticipantsEmpty,
            ]);
        } else {
            return view('fyl/yourParticipants.team', [
                'training' => $training,
                'yourTeam' =>  $yourTeam,
                'yourParticipants' => $yourParticipants,
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $newStatus = $request->input('attendance_status');
        $day = $request->input('attendance_day');

        $yourParticipants = YourParticipants::find($id);


        if ($yourParticipants) {
            
            if ($day == 'friday') {
                $yourParticipants->friday_attended = $newStatus;
                $yourParticipants->saturday_attended = $newStatus;
                $yourParticipants->sunday_attended = $newStatus;
            }
            if ($day == 'saturday') {
                $yourParticipants->saturday_attended = $newStatus;
                $yourParticipants->sunday_attended = $newStatus;
            }
            if ($day == 'sunday') {
                $yourParticipants->sunday_attended = $newStatus;
            }
            $yourParticipants->save();
            
        }
        return to_route('YourParticipants.index');
    }
    
    
    function agregaOtraSede(Request $request)
    {
        try {
            
            $DNI = $request->DNI;
            $trainingId = $request->trainingId;
            $userId = auth()->id();
            
            DB::select('CALL sp_inserta_your_other_campus(?,?,?)', [$trainingId, $DNI, $userId] );
            
            return 'success';
            
        } catch (Exception $e) {
            return $e;
        }
    }
}
