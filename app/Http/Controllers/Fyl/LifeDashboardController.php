<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\LifeParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Training;
use App\Models\Users;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Exception;

class LifeDashboardController extends Controller
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
        $today = date('Y-m-d');
        $userId = auth()->id();

        $trainings = DB::table('fyl_fds_training_view')
            ->where('user_id',$userId)
            ->orderBy('id','DESC')
            ->pluck('name','id');


        if (empty($requestData)) {
            return view('fyl/lifeParticipants/dashboard', [
                'training' => $trainings,
                'trainingId' => 0
            ]);
        } else {
            
            $trainingId = $request->training_id;

            //$dashboard = $this->dataDashboard($trainingId);
            
            $dashboard = DB::select('CALL get_fyl_life_dashboard(?)', [$trainingId]); 
            
            //return $dashboard;
            
            $pagos = DB::select('CALL get_fyl_payments_fds(?)', [$trainingId]);
            
            //return $pagos;
            
            $pagosDetails = DB::select('CALL get_fyl_payment_fds_detail(?)', [$trainingId]);
            
            //return $dashboard;

            $coach = DB::select('CALL get_fyl_coach_fds(?)', [$trainingId]);
            
            //return $dashboard;
            
            $dashboard_academy = [];
            
            $pagos_academy = [];
            
            $pagosDetails_academy = [];
            
            $academy = DB::table('fyl_fds_team as ft')
                ->join('fyl_fds as f', 'ft.fds_id', '=', 'f.id')
                ->where('f.training_in_game', '=', 19)
                ->whereNotNull('ft.DNI_coach_academia')
                ->where(DB::raw('LENGTH(ft.DNI_coach_academia)'), '>', 2)
                ->orderByDesc('ft.id')
                ->get();
            
           if($academy){
               
               $dashboard_academy = DB::select('CALL get_fyl_life_dashboard_academy(?)', [$trainingId]); 
               
               $pagos_academy = DB::select('CALL get_fyl_payments_fds_academy(?)', [$trainingId]);
               
               $pagosDetails_academy = DB::select('CALL get_fyl_payment_fds_detail_academy(?)', [$trainingId]);
               
           }
           
           $pagoMedios = DB::table('fyl_payment_participant as pp')
                            ->join('fyl_payment as p', 'pp.id', '=', 'p.fyl_payment_participant')
                            ->where('p.comment', 'Pago Medios')
                            ->where('pp.training_id',$trainingId)
                            ->count();
           
            //return $pagoMedios;
            
            $data = [
                'training' => $trainings,
                'dashboard' => $dashboard,
                'pagos' => $pagos,
                'pagosDetails' => $pagosDetails,
                'trainingId' => $trainingId,
                'coach' => $coach,
                'academy' => $academy,
                'dashboard_academy' => $dashboard_academy,
                'pagos_academy' => $pagos_academy,
                'pagosDetails_academy' => $pagosDetails_academy,
                'pagoMedios' => $pagoMedios,
                
            ];
            
            //return $data;

            return view('fyl/lifeParticipants/dashboard', $data);
        }
    }

    public function dataDashboard($training_id)
    {
        return DB::table('fyl_life_dashboard_view')->where('training_in_game', '=', $training_id)->get();
    }

    public function attendance($training)
    {
        $attendance = DB::table('fyl_focus_consolidated_attendance as fca')
            ->select([
                DB::raw('CASE DAYOFWEEK(fca.date)
            WHEN 1 THEN "Domingo"
            WHEN 2 THEN "Lunes"
            WHEN 3 THEN "Martes"
            WHEN 4 THEN "Miércoles"
            WHEN 5 THEN "Jueves"
            WHEN 6 THEN "Viernes"
            WHEN 7 THEN "Sábado"
        END AS dia'),
                'fca.total_focus'
            ])
            ->where('training_id', $training)
            ->get();

        $contador = 1;

        foreach ($attendance as $attendanceItem) {
            $attendanceItem->secuencial = $contador;
            $contador++;
        }

        return $attendance;
    }

    public function payments($training)
    {
        $payments = DB::table('fyl_focus_consolidated_payments as fcp')
            ->select([
                DB::raw('CASE DAYOFWEEK(fcp.date)
            WHEN 1 THEN "Domingo"
            WHEN 2 THEN "Lunes"
            WHEN 3 THEN "Martes"
            WHEN 4 THEN "Miércoles"
            WHEN 5 THEN "Jueves"
            WHEN 6 THEN "Viernes"
            WHEN 7 THEN "Sábado"
        END AS dia'),
                'fcp.total_focus',
                'fcp.focus',
                'fcp.focus_your',
                'fcp.focus_your_life'
            ])
            ->where('training_id', $training)
            ->get();

        $contador = 1;

        foreach ($payments as $paymentsItem) {
            $paymentsItem->secuencial = $contador;
            $contador++;
        }

        return $payments;
    }

    public function statementTable($trainingId)
    {
        $programId = 2;

        // Array asociativo con las variables que deseas reemplazar
        $bindings = [
            'trainingId' => $trainingId,
            'programId' => $programId,
        ];

        // Consulta SQL con marcadores de posición
        $query = 'SELECT DISTINCT
                    CASE DAYOFWEEK(FS.date)
                        WHEN 1 THEN "Domingo"
                        WHEN 2 THEN "Lunes"
                        WHEN 3 THEN "Martes"
                        WHEN 4 THEN "Miércoles"
                        WHEN 5 THEN "Jueves"
                        WHEN 6 THEN "Viernes"
                        WHEN 7 THEN "Sábado"
                    END AS dia,
                    (SELECT COUNT(*) FROM fyl_focus_statement WHERE statement = "SI" AND training_id = :trainingId AND program_id = :programId AND date = FS.date) AS SI,
                    (SELECT COUNT(*) FROM fyl_focus_statement WHERE statement = "P" AND training_id = :trainingId AND program_id = :programId AND date = FS.date) AS P,
                    (SELECT COUNT(*) FROM fyl_focus_statement WHERE statement = "NI" AND training_id = :trainingId AND program_id = :programId AND date = FS.date) AS NI,
                    (SELECT COUNT(*) FROM fyl_focus_statement WHERE statement = "NO" AND training_id = :trainingId AND program_id = :programId AND date = FS.date) AS NO
                FROM fyl_focus_statement as FS
                WHERE FS.training_id = :trainingId AND FS.program_id = :programId';

        // Ejecutar la consulta con los marcadores de posición
        $results = DB::select($query, $bindings);

        return $results;
    }

    public function statementLegendary($trainingId)
    {
        $datos = DB::table('fyl_focus_participants as FP')
            ->leftJoin('fyl_staff as S', 'FP.staff_DNI', '=', 'S.participant_DNI')
            ->leftJoin('fyl_focus_statement as FS', 'FP.participant_DNI', '=', 'FS.participant_DNI')
            ->leftJoin('fyl_training_team as TT', 'S.legendary_DNI', '=', 'TT.member_DNI')
            ->leftJoin('th_employees as E', 'TT.member_DNI', '=', 'E.DNI')
            ->select(
                'FS.date',
                'TT.member_DNI',
                DB::raw('CONCAT(E.names, " ", E.surnames) as legendary'),
                'FS.statement',
                DB::raw("UPPER(CASE DAYOFWEEK(FS.date)
                    WHEN 1 THEN 'Domingo'
                    WHEN 2 THEN 'Lunes'
                    WHEN 3 THEN 'Martes'
                    WHEN 4 THEN 'Miércoles'
                    WHEN 5 THEN 'Jueves'
                    WHEN 6 THEN 'Viernes'
                    WHEN 7 THEN 'Sábado' END) as date"),
                DB::raw('count(*) as count')
            )
            ->where('FP.training_id', $trainingId)
            ->whereNotNull('FS.date')
            ->whereIn('FP.attendance_status', ['ASISTIÓ', 'P', 'NO', 'NI'])
            ->groupBy('FS.date', 'TT.member_DNI', 'E.names', 'E.surnames', 'FS.statement', 'legendary')
            ->get();

        // Organizar los datos en el formato deseado
        $result = [];

        foreach ($datos as $entry) {
            $date = $entry->date;
            $legendary = $entry->legendary;
            $statement = $entry->statement;
            $count = $entry->count;

            if (!isset($result[$date][$legendary])) {
                $result[$date][$legendary] = [
                    'date' => $date,
                    'legendary' => $legendary,
                    'SI' => 0,
                    'NO' => 0,
                    'P' => 0,
                    'NI' => 0,
                ];
            }

            // Asignar el conteo al estado correspondiente
            $result[$date][$legendary][$statement] = $count;
        }

        // Reorganizar los datos en un arreglo plano
        $flatResult = [];
        foreach ($result as $date => $legendaries) {
            foreach ($legendaries as $legendary => $data) {
                $flatResult[] = $data;
            }
        }

        return $flatResult;
    }

    private function getF($trainingId)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $trainingId)
            ->where('FP.sunday_attended', 'ASISTIÓ')
            ->where('P.payment_status_focus', 'PAGO TOTAL')
            ->count();
    }

    private function getFY($trainingId)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $trainingId)
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->where('P.payment_status_focus', 'PAGO TOTAL')
            ->where('P.payment_status_your', 'PAGO TOTAL')
            ->where(function ($query) {
                $query->whereNull('P.payment_status_life')
                    ->orWhere('P.payment_status_life', '');
            })
            ->count();
    }

    private function getFYL($trainingId)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $trainingId)
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->where('P.payment_status_focus', 'PAGO TOTAL')
            ->where('P.payment_status_your', 'PAGO TOTAL')
            ->where('P.payment_status_life', 'PAGO TOTAL')
            ->count();
    }

    public function create()
    {
    }
    public function store(Request $request)
    {
    }


    private function getParticipants($currentDate, $participants)
    {
        $focusParticipants = FocusParticipants::from('fyl_focus_participants as FP')
            ->leftjoin('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_training as T', 'FP.training_id', '=', 'T.id')
            ->select(
                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                'P.nickname',
                'FP.training_id',
                'FP.participant_DNI'
            )
            ->where('T.start_date_focus', '<=', $currentDate)
            ->where('T.end_date_focus', '>=', $currentDate)
            ->where('FP.staff_DNI', $participants)
            ->orderBy('participant', 'asc')->get();

        $contador = 1;

        // Asignar el número secuencial a cada registro
        foreach ($focusParticipants as $focusParticipantsItem) {
            $focusParticipantsItem->secuencial = null;
            if ($focusParticipantsItem->rol != 'Legendario') {
                $focusParticipantsItem->secuencial = $contador;
                $contador++;
            }
        }
        return $focusParticipants;
    }

    private function getStatements($currentDate, $participants)
    {

        Carbon::setLocale('es');

        $focusStatements = FocusParticipants::from('fyl_focus_participants as FP')
            ->leftjoin('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_focus_statement as FS', 'FP.participant_DNI', '=', 'FS.participant_DNI')
            ->leftjoin('fyl_training as T', 'FP.training_id', '=', 'T.id')
            ->select(
                DB::raw("UPPER(CASE DAYOFWEEK(FS.date)
                        WHEN 1 THEN 'Domingo'
                        WHEN 2 THEN 'Lunes'
                        WHEN 3 THEN 'Martes'
                        WHEN 4 THEN 'Miércoles'
                        WHEN 5 THEN 'Jueves'
                        WHEN 6 THEN 'Viernes'
                        WHEN 7 THEN 'Sábado' END) as day"), // Obtiene el nombre del día en español
                'FS.date',
                'FS.statement',
                'FS.summary_statement',
                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant")
            )
            ->where('T.start_date_focus', '<=', $currentDate)
            ->where('T.end_date_focus', '>=', $currentDate)
            ->where('FP.staff_DNI', $participants)
            ->orderBy('participant', 'asc')
            ->orderBy('date', 'asc')->get();

        // Inicializa un arreglo para almacenar los resultados transformados
        $transformedData = [];

        // Itera sobre los resultados originales y agrupa por participante
        foreach ($focusStatements as $participantData) {
            $participantName = $participantData->participant;

            // Verifica si ya existe un registro para este participante
            if (!isset($transformedData[$participantName])) {
                // Si no existe, crea un nuevo registro con el nombre del participante
                $transformedData[$participantName] = [
                    'participant' => $participantName,
                    'days' => [],
                ];
            }

            // Agrega los datos del día al arreglo de días del participante
            $transformedData[$participantName]['days'][] = [
                'day' => $participantData->day,
                'date' => $participantData->date,
                'statement' => $participantData->statement,
                'summary_statement' => $participantData->summary_statement,
            ];
        }

        // Convierte el arreglo asociativo en un arreglo numérico
        $transformedData = array_values($transformedData);

        $contador = 1;

        // Asignar el número secuencial a cada registro
        foreach ($transformedData as &$transformedDataItem) {
            $transformedDataItem['secuencial'] = $contador;
            $contador++;
        }

        return $transformedData;
    }


    public function dashboard()
    {
        $currentDate = date('Y-m-d');
        // return $currentDate;
        $user = Users::where('id', auth()->id())->first();

        $participants = Participants::from('fyl_participants as P')
            ->select('P.DNI')
            ->where('P.email', $user->email)
            ->first();


        $focusStatements = $this->getStatements($currentDate, $participants->DNI);

        return view('fyl/focusStatement/dashboard', [
            'focusStatements' => $focusStatements
        ]);
    }

    public function show($id)
    {
        $currentDate = date('Y-m-d');
        // return $currentDate;
        $user = Users::where('id', auth()->id())->first();

        $participants = Participants::from('fyl_participants as P')
            ->select('P.DNI')
            ->where('P.email', $user->email)
            ->first();


        $focusStatements = $this->getStatements($currentDate, $participants->DNI);

        //return $focusStatements;

        return view('fyl/focusStatement/dashboard', [
            'focusStatements' => $focusStatements
        ]);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }


    public function destroy(FocusParticipants $focusParticipants)
    {
    }
}
