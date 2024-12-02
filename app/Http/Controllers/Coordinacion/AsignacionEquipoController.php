<?php

namespace App\Http\Controllers\Coordinacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;

use App\Models\Users;
use App\Models\Coordinacion\Asignaciones;
use App\Models\Coordinacion\AsignacionEquipo;

use Carbon\Carbon;
use Exception;

class AsignacionEquipoController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $userId = auth()->id();
        
        $training = DB::select('CALL fyl_get_life_activo(?)', [$userId]); 
        
        $trainingOptions = collect($training)->pluck('name', 'id');
        
        $asignaciones = Asignaciones::select('id', DB::raw("CONCAT(tipo, ' - ', nombre) AS name"))
                                    ->orderBy('tipo')
                                    ->orderBy('nombre')
                                    ->get();
        
        $asignacionEquipo = DB::table('fyl_asignacion_por_equipo as ae')
                        ->join('fyl_training as t', 'ae.training_id', '=', 't.id')
                        ->join('fyl_asignaciones as a', 'ae.asignacion_id', '=', 'a.id')
                        ->select(DB::raw("CONCAT(t.team_name, ' FYL - ', t.number) as equipo"), 'a.tipo', 'a.nombre', 'ae.*')
                        ->orderBy('ae.training_id','DESC')
                        ->orderBy('ae.para','ASC')
                        ->orderBy('a.tipo','ASC')
                        ->get();

        
        $data = [
                'training' => $trainingOptions,
                'asignaciones' => $asignaciones,
                'asignacionEquipo' => $asignacionEquipo,
                'trainingId' => 0,
            ];
        
        return view('coordinacion/asignacion-equipo/index', $data);
    }
    
    public function indexRecarga()
    {
        $asignacionEquipo = DB::table('fyl_asignacion_por_equipo as ae')
                        ->join('fyl_training as t', 'ae.training_id', '=', 't.id')
                        ->join('fyl_asignaciones as a', 'ae.asignacion_id', '=', 'a.id')
                        ->select(DB::raw("CONCAT(t.team_name, ' FYL - ', t.number) as equipo"), 'a.tipo', 'a.nombre', 'ae.*')
                        ->orderBy('ae.training_id','DESC')
                        ->orderBy('ae.para','ASC')
                        ->orderBy('a.tipo','ASC')
                        ->get();
                        
        return response()->json($asignacionEquipo); 
    }
    
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = Validator::make(
            $request->all(),
            [
                'training_id' => ['required'],
                'asignacion_id' => ['required'],
                'para' => ['required'],
                'desde' => ['required', 'date'], // Aseg¨²rate de que 'desde' sea una fecha v¨¢lida
                'hasta' => ['required', 'date', 'after:desde'],
            ]
        );
    
        // En caso de error en la validaci¨®n, devolver una respuesta JSON con los errores
        if ($validatedData->fails()) {
            $firstError = $validatedData->errors()->first(); // Obtiene el primer error
            return response()->json([
                'status' => 'error',
                'message' => $firstError, // Enviar solo el primer error
            ], 422); // 422 Unprocessable Entity
        }
        
        $userId = auth()->id();
        // Obtener la fecha y hora actual
        $hoy = Carbon::now()->toDateTimeString();
    
        // Preparar los datos para crear la asignaci¨®n
        $data = [
            'training_id' => $request->input('training_id'),
            'asignacion_id' => $request->input('asignacion_id'),
            'para' => utf8_encode($request->input('para')),
            'desde' => utf8_encode($request->input('desde')),
            'hasta' => utf8_encode($request->input('hasta')),
            'user_id' => $userId,
            'created_at' => $hoy,
            'updated_at' => $hoy,
        ];
        
        $id = $request->input('id');
        $mensaje = '';
        
        if ($id > 0) {
            $asignacionEquipo = AsignacionEquipo::find($id);
            $asignacionEquipo->update($data);
            $mensaje = 'Actualizacion exitosa'; // Convertir a UTF-8
        } else {
            // Crear la asignaci¨®n
            AsignacionEquipo::create($data);
            $mensaje = 'Asignacion exitosa'; // Convertir a UTF-8
        }
        // Devolver una respuesta JSON de ¨¦xito
        
        return response()->json([
            'status' => 'success',
            'message' => $mensaje,
        ], 200); // 200 OK
    }

    
    public function create(Request $request)
    {
        
    }
    
    
  


}
