<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\FocusParticipants;
use App\Models\Fyl\Training;
use App\Models\Fyl\Participants;
use App\Models\Fyl\ConsolidatedAttendance;
use App\Models\Fyl\ConsolidatedPayments;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Carbon\CarbonInterface;

use Illuminate\Support\Facades\Config;
use Exception;

class FocusConsolidatedController extends Controller
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

        $currentDate = date('Y-m-d');

        $endDate = date('Y-m-d', strtotime($currentDate . ' -1 day'));

        $training = DB::table('fyl_training as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->where('start_date_focus', '<=', $currentDate)
            ->where('end_date_focus', '>=', $endDate)
            ->orderBy('number', 'asc')
            ->pluck('name', 'id');


        $trainingId = 9999999999;

        if ($requestData) {
            $trainingId = $request->training_id;
        }

        $f = $this->getF($trainingId);

        $fy = $this->getFY($trainingId);

        $fyl = $this->getFYL($trainingId);

        $a = $this->getAttendance($trainingId);

        return view('fyl/focusConsolidated/index', [
            'training' => $training,
            'f' => $f,
            'fy' => $fy,
            'fyl' => $fyl,
            'a' => $a,
            'trainingId' => $trainingId,
        ]);
    }

    public function create()
    {
    }
    public function store(Request $request)
    {
        $currentDate = date('Y-m-d');

        $attendance = [
            'date' => $currentDate,
            'training_id' => $request->training_id_consolidated,
            'program_id' => $request->program_id,
            'total_focus' => $request->total_focus,
            'user_id' => auth()->id()
        ];

        $payments = [
            'date' => $currentDate,
            'training_id' => $request->training_id_consolidated,
            'program_id' => $request->program_id,
            'total_focus' => $request->total_focus,
            'focus' => $request->focus,
            'focus_your' => $request->focus_your,
            'focus_your_life' => $request->focus_your_life,
            'user_id' => auth()->id()
        ];

        $exists_attendance = ConsolidatedAttendance::where('training_id', $request->training_id_consolidated)
         ->where('date', $currentDate)->first();



        $exists_payments = ConsolidatedPayments::where('training_id', $request->training_id_consolidated)
         ->where('date', $currentDate)->first();

        if($exists_attendance){
            $exists_attendance->update($attendance);
        }
        else{
            ConsolidatedAttendance::create($attendance);
        }

        if($exists_payments){
            $exists_payments->update($payments);
        }
        else{
            ConsolidatedPayments::create($payments);
        }

        return to_route('FocusConsolidated.index')->with('status',__('Datos Consolidados!'));


    }

    private function getAttendance($training)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $training)
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->count();
    }


    private function getF($training)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $training)
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->where('P.payment_status_focus', 'PAGO TOTAL')
            ->where(function ($query) {
                $query->whereNull('P.payment_status_your')
                    ->orWhere('P.payment_status_your', '');
            })
            ->where(function ($query) {
                $query->whereNull('P.payment_status_life')
                    ->orWhere('P.payment_status_life', '');
            })
            ->count();
    }

    private function getFY($training)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $training)
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->where('P.payment_status_focus', 'PAGO TOTAL')
            ->where('P.payment_status_your', 'PAGO TOTAL')
            ->where(function ($query) {
                $query->whereNull('P.payment_status_life')
                    ->orWhere('P.payment_status_life', '');
            })
            ->count();
    }

    private function getFYL($training)
    {
        return Participants::from('fyl_participants as P')
            ->join('fyl_focus_participants as FP', 'FP.participant_DNI', '=', 'P.DNI')
            ->where('FP.training_id', $training)
            ->where('FP.attendance_status', 'ASISTIÓ')
            ->where('P.payment_status_focus', 'PAGO TOTAL')
            ->where('P.payment_status_your', 'PAGO TOTAL')
            ->where('P.payment_status_life', 'PAGO TOTAL')
            ->count();
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

        //return $focusStatements;

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
