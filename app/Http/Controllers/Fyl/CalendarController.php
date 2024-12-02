<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Training;
use App\Models\Fyl\LifeCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class CalendarController extends Controller
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
        
        $requestData = $request->all();
        
        //return $requestData;
        
        $user_id = auth()->id();
        
        $campuses = Users::find($user_id)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        

        if (empty($requestData)) {
            return view('fyl/calendar.index', [
                'campus' => $campuses,
                'campusId' => 0
            ]);
        }
        
        $campusId = $request->campus_id;
        
        $currentDate = now()->toDateString();
        
        $trainings = Training::where('campus_id', $campusId)
                     ->where('end_date_life', '>', DB::raw('CURRENT_DATE'))
                     ->select('id', DB::raw("CONCAT('FYL - ', number, ' ', COALESCE(team_name, '')) AS name"))
                     ->pluck('name','id');
        
        $data = [
                'campus' => $campuses,
                'campusId' => $campusId,
                'training' => $trainings,
                'trainingId' => 0
            ];
            
        if ($request->training_id) {
            $training_id =  $request->training_id;
        
            // Obtener los datos de las actividades desde la base de datos
            $actividades = LifeCalendar::orderBy('id', 'asc')->where('training_id',$training_id)->get(); // Ajusta el ordenamiento según necesites
        
            // Verificar si se encontró el registro
            if ($actividades) {
                // Adjuntar los datos al array $data
                $data['actividades'] = $actividades;
                $data['trainingId'] = $training_id;
            }
        }
            
           // return $data;

        return view('fyl/calendar.index',$data);
    }
    
    public function obtenerEntrenamiento(Request $request)
    {
        //return $request;
        $campus_id =  $request->campus_id;
        
        return to_route('Calendar.index', ['campus_id' => $campus_id]);
        
    }
    
    public function getCalendar(Request $request)
    {
        //return $request;
        $campus_id =  $request->campus_id;
        $training_id =  $request->training_id;
        
        return to_route('Calendar.index', ['training_id' => $training_id, 'campus_id' => $campus_id]);
        
        // Obtener los datos de las actividades desde la base de datos
        $actividades = LifeCalendar::orderBy('id', 'asc')->where('training_id',$training_id)->get(); // Ajusta el ordenamiento según necesites
    
        // Pasar los datos a la vista
        return view('fyl/calendar.index',$actividades);
        
    }


    public function create()
    {
        
    }

    public function store(Request $request)
    {
       
    }
    
    public function save(Request $request)
    {
        $actividadesJson = $request->input('actividades');
    
        // Decodificar el JSON de actividades
        $actividades = json_decode($actividadesJson, true);
    
        // Verificar si se decodificó correctamente
        if ($actividades === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Error al decodificar las actividades'], 400);
        }
    
        // Obtener el ID del usuario autenticado
        $user_id = auth()->id();
    
        // Iterar sobre las actividades y guardarlas
        foreach ($actividades as $actividad) {
            // Obtener los datos de la actividad
            $trainingId = $actividad['training_id'];
            $orden = $actividad['orden'];
        
            // Verificar si ya existe un registro con los mismos training_id e index
            $existingActividad = LifeCalendar::where('training_id', $trainingId)
                                             ->where('orden', $orden)
                                             ->first();
        
            // Si existe, actualizar; si no existe, crear un nuevo registro
            if ($existingActividad) {
                $existingActividad->update([
                    'activity' => $actividad['actividad'],
                    'start_date' => $actividad['fecha_inicio'],
                    'days' => $actividad['dias'],
                    'start_hour' => $actividad['hora_inicio'],
                    'hours' => $actividad['duracion'],
                    'user_id' => $user_id
                ]);
            } else {
                LifeCalendar::create([
                    'training_id' => $trainingId,
                    'orden' => $orden,
                    'activity' => $actividad['actividad'],
                    'start_date' => $actividad['fecha_inicio'],
                    'days' => $actividad['dias'],
                    'start_hour' => $actividad['hora_inicio'],
                    'hours' => $actividad['duracion'],
                    'user_id' => $user_id
                ]);
            }
        }
    
        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Actividades guardadas correctamente']);
    }



    public function show(Campus $Campus)
    {
        return view('fyl/campus/show',['Campus' => $Campus]);
    }

    public function edit(Campus $Campus)
    {
        /*
        $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('CI.id',
                  DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
                  )
        ->groupby('CI.id','CO.name', 'P.name','CI.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('CI.name','asc')->pluck('name','id');
        
        //return $Campus;

        return view('fyl/campus/edit', [
            'city' => $city,
            'campus' => $Campus]);


        //return view('fyl/campus/edit',['Campus' => $Campus]);
        */
    }

    public function update(Request $request, $id)
    {
        /*
        return $request;
        $campus = Campus::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'city_id' => ['required'],
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'facturacion' => ['required'],
            'botonPagos' => ['required'],
            'status' => ['required'],
        ]);

        //return $validator;

        if ($validator && $validator->fails()) {
            // Si la validaci贸n falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);
        
        //return $data;

        $campus->update($data);

        return to_route('Campus.index', $campus)->with('status','Campus updated!');
        
        */
    }

    public function destroy(Campus $Campus)
    {
        /*
        try {
            $Campus->delete();
        } catch (Exception $e) {
            return to_route('Campus.index')->with('errors','La Sede no puede ser eliminada.');
        }

        return to_route('Campus.index')->with('status',__('Campus deleted!'));
        
        */
    }


}
