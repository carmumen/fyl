<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\YourParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\YourStatement;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Exception;

class YourStatementController extends Controller
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
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado
        
        $training = DB::table('fyl_training_your_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');
         
        

        if (empty($requestData)) {

            return view('fyl/yourStatement.index', [
                'training' => $training,
                'trainingId' => 0,
                'staffDNI' => '%',
            ]);
        }
        else
        {
            $staffDNI = $request->input('staff_DNI') ?: '';
            $trainingId = $request->training_id;
            
            //return $trainingId;

            $staff = DB::table('fyl_staff_your_view')
                ->where('training_id',$trainingId)
                ->orderBy('name','asc')->pluck('name','id');

            $yourParticipants = DB::select('CALL get_fyl_your_participants_game(?,?,?)', [$trainingId, $staffDNI, $search]);
            
            $dias = DB::select('CALL get_fyl_fechas_your(?)', [$trainingId]);

            $contador = 1;

            foreach ($yourParticipants as $yourParticipantsItem) {
                $yourParticipantsItem->secuencial = $contador;
                $contador++;
            };

            return view('fyl/yourStatement/index', [
                'staffDNI' => $staffDNI,
                'staff' => $staff,
                'training' => $training,
                'trainingId' => $trainingId,
                'yourParticipants' => $yourParticipants,
                'dias' => $dias,
            ]);
        }
    }

    public function create()
    {
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'training_id' => ['required'],
            'program_id' => ['required'],
            'participant_DNI' => ['required'],
            'statement' => ['required'],
            'summary_statement' => ['nullable'],
        ]);

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $currentDate = date('Y-m-d');

        $table = [
            'training_id' => $request->input('training_id'),
            'program_id' => $request->input('program_id'),
            'participant_DNI' => $request->input('participant_DNI'),
            'date' => $currentDate,
            'statement' => $request->input('statement'),
            'summary_statement' => $request->input('summary_statement'),
            'user_id' => auth()->id()
        ];

        $exists = YourStatement::where('training_id', $request->input('training_id'))
        ->where('program_id', $request->input('program_id'))
        ->where('participant_DNI', $request->input('participant_DNI'))
        ->where('date', $currentDate)->first();

        if ($exists) {
            $exists->update($table);
        } else {
            YourStatement::create($table);
        }




        // return $currentDate;
        $user = Users::where('id', auth()->id())->first();

        $participants = Participants::from('fyl_participants as P')
            ->select('P.DNI')
            ->where('P.email', $user->email)
            ->first();

        $yourParticipants = $this->getParticipants($currentDate, $participants->DNI);

        $yourStatements = $this->getStatements($currentDate, $participants->DNI);

        return view('fyl/yourStatement/index', [
            'yourParticipants' => $yourParticipants,
            'yourStatements' => $yourStatements
        ]);
    }

    private function getParticipants($participants,$trainingId)
    {
        $yourParticipants = FocusParticipants::from('fyl_your_participants as FP')
            ->leftjoin('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_training as T', 'FP.training_id', '=', 'T.id')
            ->select(
                DB::raw("CONCAT(P.surnames,' ',P.names)  as participant"),
                'P.nickname',
                'FP.training_id',
                'FP.participant_DNI'
            )
            ->where('FP.training_id', '>=', $trainingId)
            ->where('FP.staff_DNI', $participants)
            ->orderBy('participant', 'asc')->get();

        $contador = 1;

        // Asignar el número secuencial a cada registro
        foreach ($yourParticipants as $yourParticipantsItem) {
            $yourParticipantsItem->secuencial = null;
            if ($yourParticipantsItem->rol != 'Legendario') {
                $yourParticipantsItem->secuencial = $contador;
                $contador++;
            }
        }
        return $yourParticipants;
    }

    private function getStatements($currentDate, $participants)
    {

        // Carbon::setLocale('es');

        $yourStatements = FocusParticipants::from('fyl_your_participants as FP')
            ->leftjoin('fyl_participants as P', 'FP.participant_DNI', '=', 'P.DNI')
            ->leftjoin('fyl_your_statement as FS', 'FP.participant_DNI', '=', 'FS.participant_DNI')
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
            ->where('T.start_date_your', '<=', $currentDate)
            ->where('T.end_date_your', '>=', $currentDate)
            ->where('FP.staff_DNI', $participants)
            ->orderBy('participant', 'asc')
            ->orderBy('date', 'asc')->get();

        // Inicializa un arreglo para almacenar los resultados transformados
        $transformedData = [];

        // Itera sobre los resultados originales y agrupa por participante
        foreach ($yourStatements as $participantData) {
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

    public function updateStatus(Request $request, $id)
    {
        
        $newStatus = $request->input('status');
        $staffDNI = $request->input('staff_DNI') ?: '';
        $trainingId = $request->training_id;

        $yourParticipants = YourParticipants::find($id);
        
        //return response()->json($yourParticipants);

        if ($yourParticipants) {
            $yourParticipants->statement = $newStatus;
            $yourParticipants->save();

            $yourParticipants = DB::select('CALL get_fyl_your_participants_game(?,?,?)', [$trainingId, $staffDNI, '']);

            $firstRow = collect($yourParticipants)->first();
            // Devolver los datos que deseas en la respuesta JSON
            $responseData = [
                'status' => 'success',
                'message' => 'Status actualizado correctamente',
                'newStatus' => $newStatus,

                //'life_pt' => $firstRow->life_pt,
                //'total_your_life_pt' => round((($firstRow->life_pt) * 100) / count($yourParticipants), 2),

                //'life_a' => $firstRow->life_a,
                //'your_life_a' => $firstRow->life_a,
                //'total_pt_a' => round((($firstRow->life_pt + $firstRow->life_a) * 100) / count($yourParticipants), 2),

                //'posibility' => $firstRow->posibility,
                //'agreement' => $firstRow->agreement,
                //'meta' => $firstRow->life_pt + $firstRow->life_a + $firstRow->posibility,
                //'porcentaje_meta' => round((($firstRow->life_pt + $firstRow->life_a + $firstRow->posibility) * 100) / count($yourParticipants), 2),

            ];

            return response()->json($responseData);
        }

        // Si no se encontró el participante, devolver una respuesta JSON con un mensaje de error
        $errorResponse = [
            'status' => 'error',
            'message' => 'Error al actualizar el status. Participante no encontrado.',
        ];

        return response()->json($errorResponse, 404);

        $newStatus = $request->input('status');

        $yourParticipants = YourParticipants::find($id);

        if ($yourParticipants) {
            $yourParticipants->confirm_assistance_next = $newStatus;
            $yourParticipants->save();
        }
        return to_route('YourStatement.index');
    }

    public function insertComment(Request $request, $id)
    {
        $yourParticipants = YourParticipants::find($id);

        //return $request->input('comment');

        if ($yourParticipants) {
            $yourParticipants->comment = $request->input('comment');
            $yourParticipants->save();
        }

        return response()->json(['mensaje' => 'Guardado correctamente'], 200);
    }

}
