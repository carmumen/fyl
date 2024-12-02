<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\FocusParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Training;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Exception;

class YourDashboardController extends Controller
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

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $training = DB::table('fyl_training_focus_view')->where('user_id',$userId)->pluck('name', 'id')->toArray();
        
        //return $training;
        
        $today = date('Y-m-d');
        
        if (empty($requestData)) {
            return view('fyl/yourParticipants.dashboard', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;
            
            $payments = DB::select('CALL get_fyl_dashboard_your_payment(?)', [$trainingId]);
            $attendance = DB::select('CALL get_fyl_dashboard_your_attended(?)', [$trainingId]);
            $statement = DB::select('CALL get_fyl_dashboard_your_statement(?)', [$trainingId]);
            
            $paseFocus = DB::select('CALL get_fyl_jornada_focus(?)', [$trainingId]); //PARA REPORTE DE RESUMEN FOCUS
            $seguimiento = DB::select('CALL get_seguimiento_focus_a_your(?)', [$trainingId]); //PARA REPORTE DE SEGUIMIENTO
            $inicial = DB::select('CALL get_fyl_jornada_your_inicial(?)', [$trainingId]); //PARA REPORTE DE DATOS INICIALES YOUR
            $sabado = DB::select('CALL get_fyl_jornada_your_sabado(?)', [$trainingId]); //NO SE UTILIZA
            $domingo = DB::select('CALL get_fyl_jornada_your_domingo(?)', [$trainingId]); //NO SE UTILIZA
           
            
            $gestion = DB::table('fyl_gestion_your_view')->where('training_id',$trainingId)->get(); // PARA REPORTE DE GESTION
            
            
            $jornadaPagos = DB::select('CALL get_fyl_jornada_your(?)', [$trainingId]); // PARA REPORTE JORNADA YOUR
            
            $jornada = DB::table('fyl_pagos_your_attended_view as p')
                ->select('p.*',
                    DB::raw('CASE WHEN payment_status_life = "PAGO TOTAL" AND (pago_viernes + pago_sabado + pago_domingo + pago_posterior) = 0 THEN 1 ELSE 0 END AS PSP')
                )
                ->where('p.training_id', $trainingId)
                ->orderBy('p.staff', 'ASC')
                ->orderBy('p.participant', 'ASC')
                ->get();// PARA REPORTE DETALLE JORNADA 
            
            
            return view('fyl/yourParticipants/dashboard', [
                'training' => $training,
                'trainingId' => $trainingId,
                'payments' => $payments,
                'statement' => $statement,
                'attendance' => $attendance,
                'paseFocus' => $paseFocus,
                'seguimiento'=> $seguimiento,
                'inicial' => $inicial,
                'sabado' => $sabado,
                'domingo' => $domingo,
                'gestion' => $gestion,
                'jornada' => $jornada,
                'jornadaPagos' => $jornadaPagos
            ]);
            
        }

    }
    
    public function get_training_next()
    {
        $userId = auth()->id();

        $result = DB::table('CALL fyl_get_training_next_focus(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
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
            ->leftJoin('fyl_staff_focus as S', 'FP.staff_DNI', '=', 'S.participant_DNI')
            ->leftJoin('fyl_focus_statement as FS', 'FP.participant_DNI', '=', 'FS.participant_DNI')
            ->leftJoin('fyl_training_team as TT', 'S.legendary_DNI', '=', 'TT.member_DNI')
            ->leftJoin('th_employees as E', 'TT.member_DNI', '=', 'E.DNI')
            ->select('FS.date', 'TT.member_DNI',
                    DB::raw('CONCAT(E.names, " ", E.surnames) as legendary'), 'FS.statement',
                    DB::raw("UPPER(CASE DAYOFWEEK(FS.date)
                    WHEN 1 THEN 'Domingo'
                    WHEN 2 THEN 'Lunes'
                    WHEN 3 THEN 'Martes'
                    WHEN 4 THEN 'Miércoles'
                    WHEN 5 THEN 'Jueves'
                    WHEN 6 THEN 'Viernes'
                    WHEN 7 THEN 'Sábado' END) as date"),
                    DB::raw('count(*) as count'))
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
            ->where('FP.attendance_status', 'ASISTIÓ')
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
