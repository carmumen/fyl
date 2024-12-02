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

use Carbon\Carbon;
use Exception;

class AsignacionesController extends Controller
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
        
        $asignaciones = Asignaciones::orderBy('tipo','ASC')->orderBy('nombre','ASC')->get();
        
        return view('coordinacion/asignaciones/index', ['asignaciones' => $asignaciones]);
        
    }
    
    public function indexRecargado ()
    {
        $asignaciones = Asignaciones::orderBy('tipo','ASC')->orderBy('nombre','ASC')->get();
        return response()->json($asignaciones); 
    }
    
    public function create()
    {
        
    }
    
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = Validator::make(
            $request->all(),
            [
                'tipo' => ['required'],
                'nombre' => ['required'],
                'link_formulario' => ['required'],
                'estado' => ['required'],
            ]
        );
    
        // En caso de error en la validación, devolver una respuesta JSON con los errores
        if ($validatedData->fails()) {
            $firstError = $validatedData->errors()->first(); // Obtiene el primer error
            return response()->json([
                'status' => 'error',
                'message' => $firstError, // Enviar solo el primer error
            ], 422); // 422 Unprocessable Entity
        }
        
        // Obtener la fecha y hora actual
        $hoy = Carbon::now()->toDateTimeString();
    
        // Preparar los datos para crear la asignación
        $data = [
            'tipo' => $request->input('tipo'),
            'nombre' => $request->input('nombre'),
            'link_formulario' => $request->input('link_formulario'),
            'estado' => $request->input('estado'),
            'user_id' => auth()->id(),
            'created_at' => $hoy,
            'updated_at' => $hoy,
        ];
        
        
        $id = $request->input('id');
        $mensaje = '';
        
        if($id > 0){
            $asignaciones = Asignaciones::find($id);
            $asignaciones->update($data);
            $mensaje = 'Asignación actualizada exitosamente';
        }
        else{
            // Crear la asignación
            Asignaciones::create($data);
            $mensaje = 'Asignación creada exitosamente';
        }
        // Devolver una respuesta JSON de éxito
        return response()->json([
            'status' => 'success',
            'message' => $mensaje,
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }
   


}
