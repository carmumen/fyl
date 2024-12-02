<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\FocusParticipants;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Staff;
use App\Models\Fyl\FocusStatement;
use App\Models\Fyl\FocusParticipantsComments;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Exception;

class FocusStatementController extends Controller
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
        
        //return $request;
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

 
            
        $training1 = DB::table('fyl_next_training_focus_view as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join('fyl_campus_user as CU', 'C.id', '=', 'CU.campus_id')
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->where('CU.user_id',$userId)
            ->pluck('name', 'id');
            
        $training = DB::table('fyl_training_focus_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');

        if (empty($requestData)) {

            return view('fyl/focusStatement.index', [
                'training' => $training,
                'trainingId' => 0,
                'staffDNI' => '%',
                'statementStaff' => 0,
                'confirm_assistance_next' => '%'
            ]);
        }
        else
        {
            //return $request;
            $legendaryDNI = $request->input('legendary_DNI') ?: '%';
            $staffDNI = $request->input('staff_DNI') ?: '%';
            $trainingId = $request->training_id;
            $confirmAssistanceNext = $request->input('confirm_assistance_next') ?: '%';

            $legendary = DB::table('fyl_legendary_focus_view')->where('training_id',$trainingId)->pluck('name','id');
            
            $staff = DB::table('fyl_staff_focus_view')
            ->where('training_id',$trainingId)
            ->where(function ($query) use($legendaryDNI) {
                $query->where('legendary_DNI', 'LIKE','%'.$legendaryDNI.'%')
                    ->orWhereNull('legendary_DNI');
            })
            ->orderBy('name','asc')->pluck('name','id');

            $focusParticipants = DB::select('CALL get_fyl_focus_participants_game(?,?,?,?,?)', [$trainingId, $legendaryDNI, $staffDNI, $confirmAssistanceNext, $search]);

            //return $focusParticipants;
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($focusParticipants as $focusParticipantsItem) {
                $focusParticipantsItem->secuencial = $contador;
                $focusParticipantsItem->comments = $this->cargaComentarios($focusParticipantsItem->id);
                $contador++;
            };
            
            //return $focusParticipants;
            
            $statementStaff = "0";
            
            $statement = DB::table('fyl_staff_focus')
                                ->select(DB::raw('SUM(statement) as totalStatement'))
                                ->where('training_id', $trainingId)
                                ->where('program_id', 2)
                                ->where('participant_DNI','LIKE',$staffDNI)
                                ->first();
                            
            $statementStaff = $statement->totalStatement ?? 0;
            
            return view('fyl/focusStatement/index', [
                'legendaryDNI' => $legendaryDNI,
                'legendary' => $legendary,
                'staffDNI' => $staffDNI,
                'staff' => $staff,
                'training' => $training,
                'trainingId' => $trainingId,
                'focusParticipants' => $focusParticipants,
                'statementStaff' => $statementStaff,
                'confirmAssistanceNext' => $confirmAssistanceNext
            ]);
        }
    }
    
    public function cargaComentarios($id)
    {
        $comments = DB::table('fyl_focus_participants_comments as c')
                        ->join('users as u', 'c.user_id','u.id')
                        ->select('c.*', 'u.name')
                        ->where('focus_participants_id',$id)->get();
        return $comments;
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

        $exists = FocusStatement::where('training_id', $request->input('training_id'))
        ->where('program_id', $request->input('program_id'))
        ->where('participant_DNI', $request->input('participant_DNI'))
        ->where('date', $currentDate)->first();

        if ($exists) {
            $exists->update($table);
        } else {
            FocusStatement::create($table);
        }




        // return $currentDate;
        $user = Users::where('id', auth()->id())->first();

        $participants = Participants::from('fyl_participants as P')
            ->select('P.DNI')
            ->where('P.email', $user->email)
            ->first();

        $focusParticipants = $this->getParticipants($currentDate, $participants->DNI);

        $focusStatements = $this->getStatements($currentDate, $participants->DNI);

        return view('fyl/focusStatement/index', [
            'focusParticipants' => $focusParticipants,
            'focusStatements' => $focusStatements
        ]);
    }

    private function getParticipants($participants,$trainingId)
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
            ->where('FP.training_id', '>=', $trainingId)
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

        // Carbon::setLocale('es');

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

    public function updateStatus(Request $request, $id)
    {
        $newStatus = $request->input('status');
        $legendaryDNI = $request->input('legendary_DNI') ?: '';
            $staffDNI = $request->input('staff_DNI') ?: '';
            $trainingId = $request->training_id;

    $focusParticipants = FocusParticipants::find($id);

    if ($focusParticipants) {
        $focusParticipants->confirm_assistance_next = $newStatus;
        $focusParticipants->save();
        
        $focusParticipants = DB::select('CALL get_fyl_focus_participants_game(?,?,?,?)', [$trainingId, $legendaryDNI, $staffDNI, '']);
        
        $firstRow = collect($focusParticipants)->first();
        // Devolver los datos que deseas en la respuesta JSON
        $responseData = [
            'status' => 'success',
            'message' => 'Status actualizado correctamente',
            'newStatus' => $newStatus,
            
            'your_pt' => $firstRow->your_pt,
            'life_pt' => $firstRow->life_pt,
            'your_life_pt' => $firstRow->your_pt + $firstRow->life_pt,
            'total_your_life_pt' => round((($firstRow->your_pt + $firstRow->life_pt) * 100) / count($focusParticipants), 2),
            
            
            'your_a' => $firstRow->your_a,
            'life_a' => $firstRow->life_a,
            'your_life_a' => $firstRow->your_a + $firstRow->life_a,
            'total_pt_a' => round((($firstRow->your_pt + $firstRow->life_pt + $firstRow->your_a + $firstRow->life_a) * 100) / count($focusParticipants), 2),
            
            'posibility' => $firstRow->posibility,
            'agreement' => $firstRow->agreement,
            'meta' => $firstRow->your_pt + $firstRow->life_pt + $firstRow->your_a + $firstRow->life_a + $firstRow->posibility,
            'porcentaje_meta' => round((($firstRow->your_pt + $firstRow->life_pt + $firstRow->your_a + $firstRow->life_a + $firstRow->posibility) * 100) / count($focusParticipants), 2),
            
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

        $focusParticipants = FocusParticipants::find($id);

        if ($focusParticipants) {
            $focusParticipants->confirm_assistance_next = $newStatus;
            $focusParticipants->save();
        }
        return to_route('FocusStatement.index');
    }

   public function insertComment(Request $request)
    {
        try {
            $userId = auth()->id();
            $focus_participants_id = $request->input('focus_participant_id');
            $comment_id = $request->input('comment_id');
            $comment = $request->input('comment');
            $status = $request->input('status');
            $focus_secuencial = $request->focus_secuencial;
    
            $table = [
                'focus_participants_id' => $focus_participants_id,
                'comment' => $comment,
                'status' => $status,
                'user_id' => $userId,
            ];
            
            if($comment_id == 0)
            {
                FocusParticipantsComments::create($table);
            }
            else
            {
                $coment = FocusParticipantsComments::where('id',$comment_id)->first();
                
                $coment->update($table);
            }
    
            
    
            // Aquí deberías tener la lógica para cargar los comentarios actualizados
            $comments = $this->cargaComentarios($focus_participants_id);
    
            return response()->json(['mensaje' => 'Guardado correctamente', 'focus_secuencial' => $focus_secuencial, 'comments' => $comments], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }


}
