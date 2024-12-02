<?php

namespace App\Http\Controllers\Coordinacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\Users;
use App\Models\Coordinacion\Actividad;
use App\Models\Coordinacion\Asignacion;
use App\Models\Coordinacion\Llamada;
use App\Models\Coordinacion\Comunidad;
use App\Models\Coordinacion\Equipo;
use App\Models\Coordinacion\Promesa;
use App\Models\Coordinacion\LlamadaCoordinacion;

use Exception;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;


class SeguimientoController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $requestData = $request->all();
        
        $userId = auth()->id();
        
        $campuses = Users::find($userId)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        
        $campusId = $request->input('campus_id') ?: 0;

        if (empty($requestData) || $campusId == 0) {
            
            $dataInicio = [
                'campusId' => 0, 
                'trainingId' => 0,
                'campus' => $campuses,
                'training' => [],  
            ];
            
            return view('coordinacion/seguimiento/index', $dataInicio);
        }
        
        $hoy = Carbon::today()->toDateString();
        
        $training = DB::table('fyl_training')
                    ->select('id', 
                             DB::raw("COALESCE(team_name, CONCAT('FYL - ', number)) as name"))
                    ->where('campus_id', $campusId)
                    ->where('start_date_life', '<=', $hoy)
                    ->where('end_date_life', '>=', $hoy)
                    ->pluck('name','id');
                    
        $trainingId = $request->input('training_id');
        
        $seguimiento = [];
        
        if($trainingId > 0)
        {
            $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        }
        
        $contador = 1;

        foreach ($seguimiento as $seguimientoItem) {
            $seguimientoItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'campus' => $campuses,
            'training' => $training,
            'seguimiento' => $seguimiento,
            ];
            
            //return $campusId;
        
        return view('coordinacion/seguimiento/index',$data);
    }
    
    public function obtenerEntrenamiento(Request $request)
    {
        //return $request;
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $data = [
            'campus_id' => $campusId,
            'training_id' => $trainingId,
            ];
            
            //return $data;
        
        return to_route('Seguimiento.index', $data);
        
    }
    
    public function promesas(Request $request)
    {
        $hoy = Carbon::now()->toDateTimeString();
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        
        $filtrados = array_filter($seguimiento, function($item) {
            return $item->activo === 'SI'; // Asegúrate de que el campo se llame 'estado'
        });

        // Si necesitas convertirlo de nuevo a un array
        $seguimiento = array_values($filtrados);
        
        //return $seguimiento;
        
        $existe = DB::table('seguimiento_promesas')->where('training_id', $trainingId)->exists();

        if (!$existe) {
            foreach ($seguimiento as $registro) {
                DB::table('seguimiento_promesas')->insert([
                    'training_id' => $trainingId,
                    'participant_DNI' => $registro->participant_DNI,
                    'rol' => $registro->role,
                    'surnames_names' => $registro->surnames_names,
                    'created_at' => $hoy,
                    'updated_at' => $hoy,
                ]);
            }
        } 
        
        $promesas = DB::table('seguimiento_promesas')
                        ->where('training_id', $trainingId)
                        ->get();
        
        $contador = 1;

        foreach ($promesas as $promesasItem) {
            $promesasItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'promesa' => $promesas,
            ];
        
        return view('coordinacion/seguimiento/promesas',$data);
    }
    
    public function actualizarPromesas(Request $request) 
    {
        $id = $request->input('id') ?: 0;
        $campo = $request->input('campo') ?: '';
        $respuesta = $request->input('respuesta') ?: '';
        
        // Inicializar el campo de la tabla
        $campoTabla = "";
        
        // Determinar el campo de la tabla basado en el campo proporcionado
        switch ($campo) {
            case "1":
                $campoTabla = "promesa1";
                break;
            case "2":
                $campoTabla = "promesa2";
                break;
            case "3":
                $campoTabla = "promesa3";
                break;
            case "4":
                $campoTabla = "promesa4";
                break;
            case "5":
                $campoTabla = "promesa5";
                break;
            case "6":
                $campoTabla = "promesa6";
                break;
            case "7":
                $campoTabla = "promesa7";
                break;
            case "8":
                $campoTabla = "promesa8";
                break;
            case "9":
                $campoTabla = "promesa9";
                break;
            case "10":
                $campoTabla = "promesa10";
                break;
            default:
                return response()->json(['error' => 'Campo no válido'], 400);
        }
        
        // Encontrar la actividad
        $promesa = Promesa::find($id);
        
        if (!$promesa) {
            return response()->json(['error' => 'Promesa no encontrada'], 404);
        }
        
        // Preparar los datos para actualizar
        $data = [
            $campoTabla => $respuesta,
        ];
        
        // Actualizar la actividad
        $promesa->update($data);
        
        return response()->json(['success' => 'Promesa actualizada con éxito']);
    }
    
    public function actividades(Request $request)
    {
        $hoy = Carbon::now()->toDateTimeString();
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        
        $filtrados = array_filter($seguimiento, function($item) {
            return $item->activo === 'SI'; // Asegúrate de que el campo se llame 'estado'
        });

        // Si necesitas convertirlo de nuevo a un array
        $seguimiento = array_values($filtrados);
        
        //return $seguimiento;
        
        $existe = DB::table('seguimiento_actividades')->where('training_id', $trainingId)->exists();

        if (!$existe) {
            foreach ($seguimiento as $registro) {
                DB::table('seguimiento_actividades')->insert([
                    'training_id' => $trainingId,
                    'participant_DNI' => $registro->participant_DNI,
                    'rol' => $registro->role,
                    'surnames_names' => $registro->surnames_names,
                    'created_at' => $hoy,
                    'updated_at' => $hoy,
                ]);
            }
        } 
        
        $actividades = DB::table('seguimiento_actividades')
                        ->where('training_id', $trainingId)
                        ->get();
        
        $contador = 1;

        foreach ($actividades as $actividadesItem) {
            $actividadesItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'actividades' => $actividades,
            ];
        
        return view('coordinacion/seguimiento/actividades',$data);
    }
    
    public function actualizarActividad(Request $request) 
    {
        $id = $request->input('id') ?: 0;
        $campo = $request->input('campo') ?: '';
        $respuesta = $request->input('respuesta') ?: '';
        
        // Inicializar el campo de la tabla
        $campoTabla = "";
        
        // Determinar el campo de la tabla basado en el campo proporcionado
        switch ($campo) {
            case "rc":
                $campoTabla = "reunion_coordinacion";
                break;
            case "ac":
                $campoTabla = "actividad_confianza";
                break;
            case "rp":
                $campoTabla = "revision_promesas";
                break;
            case "tf":
                $campoTabla = "toma_foto_inicial";
                break;
            case "la1":
                $campoTabla = "linea_abrazos_1";
                break;
            case "ml1":
                $campoTabla = "marcha_legendarios_1";
                break;
            case "at":
                $campoTabla = "actividad_tanque";
                break;
            case "pm":
                $campoTabla = "punto_magia";
                break;
            case "rp1":
                $campoTabla = "revision_promesas_1";
                break;
            case "v1":
                $campoTabla = "vuelos_1";
                break;
            case "s":
                $campoTabla = "susurros";
                break;
            case "rd":
                $campoTabla = "reto_dinero";
                break;
            case "sp1":
                $campoTabla = "seguimiento_promesas_1";
                break;
            case "la2":
                $campoTabla = "linea_abrazos_2";
                break;
            case "pa":
                $campoTabla = "paso_antorcha";
                break;
            case "ml2":
                $campoTabla = "marcha_legendarios_2";
                break;
            case "rb":
                $campoTabla = "rompimiento_barreras";
                break;
            case "rt":
                $campoTabla = "reto_tiempo";
                break;
            case "sp2":
                $campoTabla = "seguimiento_promesas_2";
                break;
            case "v2":
                $campoTabla = "vuelos_2";
                break;
            case "mis":
                $campoTabla = "mezcla_intimar_susurros";
                break;
            case "rp2":
                $campoTabla = "revision_promesas_2";
                break;
            default:
                return response()->json(['error' => 'Campo no válido'], 400);
        }
        
        // Encontrar la actividad
        $actividad = Actividad::find($id);
        
        if (!$actividad) {
            return response()->json(['error' => 'Actividad no encontrada'], 404);
        }
        
        // Preparar los datos para actualizar
        $data = [
            $campoTabla => $respuesta,
        ];
        
        // Actualizar la actividad
        $actividad->update($data);
        
        return response()->json(['success' => 'Actividad actualizada con éxito']);
    }
    
    public function asignaciones(Request $request)
    {
        $hoy = Carbon::now()->toDateTimeString();
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        
        $filtrados = array_filter($seguimiento, function($item) {
            return $item->activo === 'SI'; // Asegúrate de que el campo se llame 'estado'
        });

        // Si necesitas convertirlo de nuevo a un array
        $seguimiento = array_values($filtrados);
        
        $existe = DB::table('seguimiento_asignaciones')->where('training_id', $trainingId)->exists();
        

        if (!$existe) {
            foreach ($seguimiento as $registro) {
                DB::table('seguimiento_asignaciones')->insert([
                    'training_id' => $trainingId,
                    'participant_DNI' => $registro->participant_DNI,
                    'rol' => $registro->role,
                    'surnames_names' => $registro->surnames_names,
                    'created_at' => $hoy,
                    'updated_at' => $hoy,
                ]);
            }
        } 
        
        $asignaciones = DB::table('seguimiento_asignaciones')
                        ->where('training_id', $trainingId)
                        ->get();
        
        $contador = 1;

        foreach ($asignaciones as $actividadesItem) {
            $actividadesItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'asignaciones' => $asignaciones,
            ];
        
        return view('coordinacion/seguimiento/asignaciones',$data);
    }
    
    public function actualizarAsignacion(Request $request) 
    {
        
        $id = $request->input('id') ?: 0;
        $campo = $request->input('campo') ?: '';
        $respuesta = $request->input('respuesta') ?: '';
        
        // Inicializar el campo de la tabla
        $campoTabla = "";
        
        // Determinar el campo de la tabla basado en el campo proporcionado
        switch ($campo) {
            case "l4a":
                $campoTabla = "los_4_acuerdos";
                break;
            case "kfp":
                $campoTabla = "kung_fu_panda";
                break;
            case "a":
                $campoTabla = "avatar";
                break;
            case "sse":
                $campoTabla = "santo_surfista_ejecutivo";
                break;
            case "sdln":
                $campoTabla = "sociedad_de_la_nieve";
                break;
            case "mda":
                $campoTabla = "maestria_del_amor";
                break;
            case "epdm":
                $campoTabla = "el_precio_del_manana";
                break;
            case "e":
                $campoTabla = "elementos";
                break;
            default:
                return response()->json(['error' => 'Campo no válido'], 400);
        }
        
        // Encontrar la actividad
        $asignacion = Asignacion::find($id);
        
        if (!$asignacion) {
            return response()->json(['error' => 'Asignacion no encontrada'], 404);
        }
        
        // Preparar los datos para actualizar
        $data = [
            $campoTabla => $respuesta,
        ];
        
        // Actualizar la actividad
        $asignacion->update($data);
        
        return response()->json(['success' => 'Asignaci&oacute;n actualizada con éxito']);
    }
    
    public function llamadas(Request $request)
    {
        $hoy = Carbon::now()->toDateTimeString();
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        
        $filtrados = array_filter($seguimiento, function($item) {
            return $item->activo === 'SI'; // Asegúrate de que el campo se llame 'estado'
        });

        // Si necesitas convertirlo de nuevo a un array
        $seguimiento = array_values($filtrados);
        
        $existe = DB::table('seguimiento_llamadas')->where('training_id', $trainingId)->exists();
        

        if (!$existe) {
            foreach ($seguimiento as $registro) {
                DB::table('seguimiento_llamadas')->insert([
                    'training_id' => $trainingId,
                    'participant_DNI' => $registro->participant_DNI,
                    'rol' => $registro->role,
                    'surnames_names' => $registro->surnames_names,
                    'created_at' => $hoy,
                    'updated_at' => $hoy,
                ]);
            }
        } 
        
        $llamadas = DB::table('seguimiento_llamadas')
                        ->where('training_id', $trainingId)
                        ->get();
        
        $contador = 1;

        foreach ($llamadas as $actividadesItem) {
            $actividadesItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'llamadas' => $llamadas,
            ];
        
        return view('coordinacion/seguimiento/llamadas',$data);
    }
    
    public function actualizarLlamadas(Request $request) 
    {
        
        $id = $request->input('id') ?: 0;
        $campo = $request->input('campo') ?: '';
        $respuesta = $request->input('respuesta') ?: '';
        
        // Inicializar el campo de la tabla
        $campoTabla = "";
        
        // Determinar el campo de la tabla basado en el campo proporcionado
        switch ($campo) {
            case "1":
                $campoTabla = "llamada_1";
                break;
            case "2":
                $campoTabla = "llamada_2";
                break;
            case "3":
                $campoTabla = "llamada_3";
                break;
            case "4":
                $campoTabla = "llamada_4";
                break;
            case "5":
                $campoTabla = "llamada_5";
                break;
            case "6":
                $campoTabla = "llamada_6";
                break;
            case "7":
                $campoTabla = "llamada_7";
                break;
            case "8":
                $campoTabla = "llamada_8";
                break;
            case "9":
                $campoTabla = "llamada_9";
                break;
            case "10":
                $campoTabla = "llamada_10";
                break;
            case "11":
                $campoTabla = "llamada_11";
                break;
            case "12":
                $campoTabla = "llamada_12";
                break;
            case "13":
                $campoTabla = "llamada_13";
                break;
            case "14":
                $campoTabla = "llamada_14";
                break;
            default:
                return response()->json(['error' => 'Campo no válido'], 400);
        }
        
        // Encontrar la actividad
        $llamada = Llamada::find($id);
        
        if (!$llamada) {
            return response()->json(['error' => 'Llamada no encontrada'], 404);
        }
        
        // Preparar los datos para actualizar
        $data = [
            $campoTabla => $respuesta,
        ];
        
        // Actualizar la actividad
        $llamada->update($data);
        
        return response()->json(['success' => 'Llamada registrada con éxito']);
    }
    
    public function equipo(Request $request){
        $hoy = Carbon::now()->toDateTimeString();
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        
        $filtrados = array_filter($seguimiento, function($item) {
            return $item->activo === 'SI'; // Asegúrate de que el campo se llame 'estado'
        });

        // Si necesitas convertirlo de nuevo a un array
        $seguimiento = array_values($filtrados);
        
        $existe = DB::table('seguimiento_equipo')->where('training_id', $trainingId)->exists();
        

        if (!$existe) {
            foreach ($seguimiento as $registro) {
                DB::table('seguimiento_equipo')->insert([
                    'training_id' => $trainingId,
                    'participant_DNI' => $registro->participant_DNI,
                    'rol' => $registro->role,
                    'surnames_names' => $registro->surnames_names,
                    'created_at' => $hoy,
                    'updated_at' => $hoy,
                ]);
            }
        } 
        
        $equipo = DB::table('seguimiento_equipo')
                        ->where('training_id', $trainingId)
                        ->get();
        
        $contador = 1;

        foreach ($equipo as $equipoItem) {
            $equipoItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'equipo' => $equipo,
            ];
        
        return view('coordinacion/seguimiento/equipo',$data);
    }
    
    public function actualizarEquipo(Request $request) 
    {
        
        $id = $request->input('id') ?: 0;
        $campo = $request->input('campo') ?: '';
        $respuesta = $request->input('respuesta') ?: '';
        
        // Inicializar el campo de la tabla
        $campoTabla = "";
        
        // Determinar el campo de la tabla basado en el campo proporcionado
        switch ($campo) {
            case "2":
                $campoTabla = "fds_2";
                break;
            case "3":
                $campoTabla = "fds_3";
                break;
            default:
                return response()->json(['error' => 'Campo no válido'], 400);
        }
        
        // Encontrar la actividad
        $equipo = Equipo::find($id);
        
        if (!$equipo) {
            return response()->json(['error' => 'Equipo no encontrado'], 404);
        }
        
        // Preparar los datos para actualizar
        $data = [
            $campoTabla => $respuesta,
        ];
        
        // Actualizar la actividad
        $equipo->update($data);
        
        return response()->json(['success' => 'Equipo registrado con éxito']);
    }
    
    public function comunidad(Request $request){
        $hoy = Carbon::now()->toDateTimeString();
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        
        $seguimiento = DB::select('CALL fyl_resultados_life(?)', [$trainingId]);
        
        $filtrados = array_filter($seguimiento, function($item) {
            return $item->activo === 'SI'; // Asegúrate de que el campo se llame 'estado'
        });

        // Si necesitas convertirlo de nuevo a un array
        $seguimiento = array_values($filtrados);
        
        $existe = DB::table('seguimiento_comunidad')->where('training_id', $trainingId)->exists();
        

        if (!$existe) {
            foreach ($seguimiento as $registro) {
                DB::table('seguimiento_comunidad')->insert([
                    'training_id' => $trainingId,
                    'participant_DNI' => $registro->participant_DNI,
                    'rol' => $registro->role,
                    'surnames_names' => $registro->surnames_names,
                    'created_at' => $hoy,
                    'updated_at' => $hoy,
                ]);
            }
        } 
        
        $comunidad = DB::table('seguimiento_comunidad')
                        ->where('training_id', $trainingId)
                        ->get();
        
        $contador = 1;

        foreach ($comunidad as $comunidadItem) {
            $comunidadItem->secuencial = $contador;
            $contador++;
        }
        
        $data = [
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'comunidad' => $comunidad,
            ];
        
        return view('coordinacion/seguimiento/comunidad',$data);
    }
    
    public function actualizarComunidad(Request $request) 
    {
        
        $id = $request->input('id') ?: 0;
        $campo = $request->input('campo') ?: '';
        $respuesta = $request->input('respuesta') ?: '';
        
        // Inicializar el campo de la tabla
        $campoTabla = "";
        
        // Determinar el campo de la tabla basado en el campo proporcionado
        switch ($campo) {
            case "ml":
                $campoTabla = "mini_legado";
                break;
            case "l":
                $campoTabla = "legado";
                break;
            default:
                return response()->json(['error' => 'Campo no válido'], 400);
        }
        
        // Encontrar la actividad
        $legado = Comunidad::find($id);
        
        if (!$legado) {
            return response()->json(['error' => 'Legado no encontrado'], 404);
        }
        
        // Preparar los datos para actualizar
        $data = [
            $campoTabla => $respuesta,
        ];
        
        // Actualizar la actividad
        $legado->update($data);
        
        return response()->json(['success' => 'Legado registrado con éxito']);
    }
    
    public function create(Request $request)
    {
        
    }
    
    public function store(Request $request)
    {
        $hoy = Carbon::now()->toDateTimeString();
        $id = $request->input('llamada_id') ?: 0;
        $trainingId = $request->input('training_id');
        $campusId = $request->input('campus_id');
        $participant_DNI = $request->input('participant_DNI');
        $resumen_llamada = $request->input('resumen_llamada');
        $userId = auth()->id();
        
        $data = [
            'fecha' => $hoy,
            'training_id' => $trainingId,
            'participant_DNI' => $participant_DNI,
            'resumen_llamada' => $resumen_llamada,
            'user_id' => $userId,
            'created_at' => $hoy,
            'updated_at' => $hoy,
            ];
        
        $llamada = LlamadaCoordinacion::find($id);

        if ($llamada) {
            $llamada->update($data);
        } else {
            LlamadaCoordinacion::create($data);
        }
        
        $dataId = $participant_DNI.'|'.$trainingId.'|'.$campusId;
                    
        return to_route('Seguimiento.show', $dataId);
    }

    public function show($id)
    {
        //return $id;
        $array = explode('|', $id);
        
        $DNI = $array[0];
        $trainingId = $array[1];
        $campusId = $array[2];
        
        $participante = DB::table('fyl_participants')
                        ->select('surnames_names')
                        ->where('DNI',$DNI)
                        ->get();
                  
        $actividades = DB::table('seguimiento_actividades')
                        ->where('training_id', $trainingId)
                        ->where('participant_DNI',$DNI)
                        ->get();
                        
        $asignaciones = DB::table('seguimiento_asignaciones')
                        ->where('training_id', $trainingId)
                        ->where('participant_DNI',$DNI)
                        ->get();
                        
        $llamadas = DB::table('seguimiento_llamadas')
                        ->where('training_id', $trainingId)
                        ->where('participant_DNI',$DNI)
                        ->get();
        
        $equipo = DB::table('seguimiento_equipo')
                        ->where('training_id', $trainingId)
                        ->where('participant_DNI',$DNI)
                        ->get();
        
        $comunidad = DB::table('seguimiento_comunidad')
                        ->where('training_id', $trainingId)
                        ->where('participant_DNI',$DNI)
                        ->get();
        
        $enrolados = DB::table('fyl_participants')
                        ->where('training_id_enroller', $trainingId)
                        ->where('DNI_enroller',$DNI)
                        ->count();
        
        $sentados = DB::table('fyl_focus_participants')
                        ->where('training_id_enroller', $trainingId)
                        ->where('DNI_enroller',$DNI)
                        ->where('friday_attended','ASISTIÓ')
                        ->count();
                        
        $llamada_coordinacion = DB::table('seguimiento_llamada_coordinacion as s')
                                    ->select('s.*','u.name as usuario')
                                    ->join('users as u', 's.user_id','=','u.id')
                                    ->where('training_id', $trainingId)
                                    ->where('participant_DNI',$DNI)
                                    ->orderBy('s.fecha', 'DESC')
                                    ->get();
        
        $contador = 1;

        foreach ($llamada_coordinacion as $llamada_coordinacionItem) {
            $llamada_coordinacionItem->secuencial = $contador;
            $contador++;
        }

                        
        $data = [
            'participant_DNI' => $DNI,
            'trainingId' => $trainingId,
            'campusId' => $campusId,
            'enrolados' => $enrolados,
            'actividades' => $actividades,
            'asignaciones' => $asignaciones,
            'llamadas' => $llamadas,
            'equipo' => $equipo,
            'comunidad' => $comunidad,
            'enrolados' => $enrolados,
            'sentados' => $sentados,
            'llamada_coordinacion' => $llamada_coordinacion,
            'participante' => $participante
            ];
            
        return view('coordinacion/seguimiento/participante',$data);
    }

    public function edit( $id)
    {
        $parts = explode('|', $id);
        
        $Promesa = Promesa::where('participant_DNI',$parts[0])
                    ->where('training_id',$parts[1])
                    ->get();

        $contador = 1;
        
        foreach ($Promesa as $PromesaItem) {
            $PromesaItem->secuencial = $contador;
            $contador++;
        }
        
        $Participante = '';
        
        if ($Promesa->isNotEmpty()) {
            $userId = $Promesa->first()->user_id; // Obtén el user_id del primer elemento
        
            $usuario = DB::table('users as u')
                              ->where('id', $userId)
                              ->first(); // Usa first() para obtener un solo registro
        
            $Participante = $usuario->name;
            
        }
        
        $Observacion = DB::table('fyl_promesa_observacion as o')
                          ->join('fyl_participants_promesas as p', 'o.promesa_id','=','p.id')
                          ->join('users as u', 'o.user_id','=','u.id')
                          ->select('o.promesa_id',
                                   'o.updated_at',
                                   'u.name',
                                   'o.observacion'
                              )
                         ->where('p.participant_DNI',$parts[0])
                         ->where('p.training_id',$parts[1])
                       ->orderby('o.created_at','DESC')
                           ->get();
                           
        
        
        $Contrato = DB::table('fyl_participants_contrato as c')
                         ->where('c.participant_DNI',$parts[0])
                         ->where('c.training_id',$parts[1])
                           ->get();
                           
        
        
        $ObservacionContrato = DB::table('fyl_contrato_observacion as o')
                          ->join('fyl_participants_contrato as c', 'o.contrato_id','=','c.id')
                          ->join('users as u', 'o.user_id','=','u.id')
                          ->select('o.contrato_id',
                                   'o.updated_at',
                                   'u.name',
                                   'o.observacion'
                              )
                         ->where('c.participant_DNI',$parts[0])
                         ->where('c.training_id',$parts[1])
                       ->orderby('o.created_at','DESC')
                           ->get();
                           
        $data = [
                'Contrato' => $Contrato,
                'Promesa' => $Promesa,
                'Observacion' => $Observacion,
                'Participante' => $Participante,
                'ObservacionContrato' => $ObservacionContrato,
            ];
            
        //return $data;
        
        return view('coordinacion/edit',$data);
    }
    
    public function update(Request $request, Promesa $Promesa)
    {
        //return $request;
        $userId = auth()->id();
        
        $dataPromesa = [
                        'estado' => $request->input('estado'),
                        'user_aprobador' => $userId
                       ];
        
        $Promesa->update($dataPromesa);
        
        if($request->input('estado') == 'OBSERVADO')
        {
            $dataObservacion = [
                                'promesa_id' => $Promesa->id,
                                'observacion' => '*PROMESA '. $request->input('promesa') . ': *' . $request->input('observacion'),
                                'user_id' => $userId,
                            ];
                            
            Observacion::create($dataObservacion);
        }
        
        $id = $Promesa->participant_DNI.'|'.$Promesa->training_id;
    
        return redirect()->route('Promesa.edit', $id)->with('mensaje', 'Revisi贸n registrada');
    }
    
    public function updateContrato(Request $request, Contrato $Contrato)
    {
        //return $request;
        
        $userId = auth()->id();
        
        $dataContrato = [
                        'estado' => $request->input('estado'),
                        'user_id' => $userId
                       ];
        
        $Contrato->update($dataContrato);
        
        if($request->input('estado') == 'OBSERVADO')
        {
            $dataObservacion = [
                                'contrato_id' => $Contrato->id,
                                'observacion' => '*CONTRATO, VISION Y PROPOSITO: *' . $request->input('observacion'),
                                'user_id' => $userId,
                            ];
                            
                            //return $dataObservacion;
                            
            ObservacionContrato::create($dataObservacion);
        }
        
        $id = $Contrato->participant_DNI.'|'.$Contrato->training_id;
    
        return redirect()->route('Promesa.edit', $id)->with('mensaje', 'Revisi贸n registrada');
        
        
    }



    public function destroy(Promesa $Promesa)
    {
        
    }


}
