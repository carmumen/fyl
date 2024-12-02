<?php

namespace App\Http\Controllers\Life;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\Fyl\Participants;
use App\Models\Fyl\IndividualCode;
use App\Models\Fyl\LoginLife;
use App\Models\Pasarela\PagoMedios;

use Exception;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;


class LifeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        $userId = auth()->id();
        
        //$pagos = $this->pagos($userId);

        $enrolados = DB::select('CALL fyl_mi_enrolamiento(?)', [$userId]);
        
        
        
        $contador = 1;

        foreach ($enrolados as $enroladosItem) {
            $enroladosItem->secuencial = $contador;
            $contador++;
        }
        
        return view('fyl/life/index',[
                        'enrolados' => $enrolados
                    ]);
    }
    
    /*
    public function pagos($userId)
    {
        return DB::table('pago_medios')->where()->get();
    }
    */
    
    public function enroller()
    {
        $userId = auth()->id();

        //$training_id = $this->getTrainingNext();

        $training = DB::table('fyl_current_training_view')->where('user_id', $userId)->get();

        return view('fyl/life/enroller',[
            'trainingId' => 0,
            'training' => $training
        ]);
        
        return view('fyl/life/enroller');
    }
    
    public function generateCodeEnroller(Request $request)
    {
        $startDate = date('Y-m-d H:i:s'); // Obtiene la hora actual en formato 'Y-m-d H:i:s'
        $endDate = date('Y-m-d H:i:s', strtotime($startDate . ' +2 hours')); // Suma 2 horas a la hora actual

        $userId = auth()->id();

        $urlBase = config('app.url');

        $training = DB::table('fyl_current_training_view')->where('user_id', $userId)->get();
        
        $trainingId = $request->training_in_game;
        $DNI_enroller = $request->DNI_enroller;
        $trainingId = $request->training_id;
        $campusId = $request->campus_id;
        $trainingEnroller = $request->training_id_enroller;

        $exists = DB::table('fyl_enrollment_individual_code')
                    ->where('campus_id', $campusId)
                    ->where('training_id_enroller', $trainingEnroller)
                    ->where('training_id', $trainingId)
                    ->where('DNI_enroller', $DNI_enroller)
                    ->where('end_date', '>', $startDate)
                    ->selectRaw('TIMEDIFF(DATE_SUB(NOW(), INTERVAL 5 HOUR),end_date) as time_diff, code, end_date, TIME(end_date) as time')
                    ->first();

        if ($exists) {
            $timeDiff = Carbon::parse($exists->time_diff);
            $hours = $timeDiff->format('H');
            $minutes = $timeDiff->format('i');

            $link = $urlBase . '/inscriptionL/focus?opc=' . $exists->code;

            return view('fyl/life/enroller',[
                'error' => 'Su enlace estará activo hasta las '. $exists->time,
                'trainingId' => $trainingId,
                'training' => $training,
                'link' => $link,
            ]);
        }


        $team = $startDate . strval($trainingId);
        $hashedDate = hash('sha256', $team);
        $hashedDate = substr($hashedDate, 0, 60);

        $tablaCode = [
            'campus_id' => $campusId,
            'training_id' => $trainingId,
            'training_id_enroller' =>  $trainingEnroller,
            'DNI_enroller' => $DNI_enroller,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'code' => $hashedDate,
            'user_id' => $userId
        ];

        IndividualCode::create($tablaCode);

        $link = $urlBase . '/inscriptionL/focus?opc=' . $hashedDate;

        return view('fyl/life/enroller',[
            'trainingId' => $trainingId,
            'training' => $training,
            'link' => $link,
        ]);
    }
    
    function generaLink(Request $request)
    {
        try{
            $userId = auth()->id();
            $result = DB::select('CALL fyl_precio_enrolador(?)', [$userId]);
            
            
            $priceConIVA = $result[0]->price;
            $porcentajeIVA = $result[0]->porcentaje_IVA;
            
            
            $precio = round(($priceConIVA / (1 + $porcentajeIVA)),2);
            $precio = strval($precio);
            
            $iva = round($priceConIVA - $precio,2);
            $iva = strval($iva);
            
            $participant = Participants::where('hash',$request->id)->first();
            $document_type = '05';
            
            
            
            if($document_type == 'RUC')
                $document_type = '04';
                
            $uuid = $this->generarUUID();
            
            $data = [
                    "integration" => true,
                    "third" => [
                        "document" => $participant->DNI,
                        "document_type" => $document_type,
                        "name" => $participant->surnames_names,
                        "email" => $participant->email,
                        "phones" => $participant->phone,
                        "address" => $participant->address,
                        "type" => "Individual"
                    ],
                    "generate_invoice" => 0,
                    "description" => "Pago Focus",
                    "amount" => $priceConIVA,//1.15,//$priceConIVA,
                    "amount_with_tax" => $precio,//1.0,//$precio,
                    "amount_without_tax" => "0.0",
                    "tax_value" => $iva,//0.15,//$iva,
                    "settings" => [],
                    "notify_url" => 'https://focusyourlife.org/pagomedios',
                    "custom_value" => $uuid."|".$participant->DNI,
                    "has_cash" => 0,
                    "has_cards" => 1
                ];
                
            
    
            $pasarela = DB::table('pasarela_boton')->where('campus_id',$request->campus_id)->first();
            
            
             $response = Http::withHeaders([
                    'Accept' => $pasarela->accept,
                    'Content-Type' => $pasarela->content_type,
                    'Authorization' => $pasarela->authorization,
                ])->post($pasarela->url, $data);
            
            $responseData = $response->json();

            // Validar el campo "success"
            if (isset($responseData['success']) && $responseData['success'] === true) {
                $dataResponse = [
                        'url' => $response['data']['url'],
                        'token' => $response['data']['token'],
                        'participant_DNI' => $participant->DNI,
                        'uuid' => $uuid,
                    ];
                    
                PagoMedios::create($dataResponse);
            } else {
                $errorMessage="";
                if (isset($responseData['data'])) {
                    foreach ($responseData['data'] as $errorData) {
                        if (isset($errorData['field']) && $errorData['field'] === 'Tercero') {
                            // Verificar si el campo "message" es un arreglo y si tiene al menos un elemento
                            if (isset($errorData['message']['document']) && is_array($errorData['message']['document']) && count($errorData['message']['document']) > 0) {
                                $errorMessage = $errorData['message']['document'][0];
                                break; // Salir del bucle una vez que se encuentre el mensaje
                            }
                        }
                    }
                }
                throw new \Exception("Error en la solicitud: " . utf8_decode(utf8_encode(json_decode('"' . $errorMessage . '"'))));
            }
               
            
            
            return $response->json();
            
        }catch (\Exception $e) {
            //return $e->getMessage();
            return response()->json(['success' => false, 'error' => $e->getMessage()],500);
        }
    }
    
    
    
    
    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }


    public function create(Request $request)
    {
       return $request;
    }

    public function login(Request $request)
    {
        //return $request;
        
                            
        
       if ($request->isMethod('post')) {
           
            $participant = DB::table('fyl_participants_life_login_view')
                            ->where('email',$request->email)
                            ->where('participant_DNI',$request->identidad)
                            ->first();
                            
            if($participant){
                try {
                    // Si el formulario se envió por POST, genera y envía el código de verificación
            
                    // Generar un código aleatorio de 6 dígitos
                    $codigo = mt_rand(100000, 999999);
                    
                    // Simular el envío por correo electrónico
                    $correo_destino = "cemm4@hotmail.com";//
                    $asunto = "Código de Verificación";
                    $mensaje = "Su código de verificación es: $codigo";
                    
                    $uuid = $this->generarUUID();
                    $vigencia = $this->vigencia();
                    
                    $data = [ 
                        'uuid' => $uuid,
                        'hash' => $participant->hash,
                        'password' => $codigo,
                        'vigencia' => $vigencia,
                        ];
                        
                    LoginLife::create($data);
                    
                    
                    // Enviar el correo electrónico usando Laravel Mail
                    Mail::to($correo_destino)->send(new CodigoVerificacionCorreo($codigo));
                    
                    return view('fyl/life/autenticacion', [
                        'clave' => $uuid
                    ]);
                }
                catch (\Exception $e) {
                    $mensaje = $e->getMessage();
                    Session::flash('error', $mensaje);
                    return redirect()->back()->withInput();
                }
            }
            else{
                $mensaje = 'Las credenciales proporcionadas no son válidas.';
                Session::flash('error', $mensaje);
                return redirect()->back()->withInput();
            }
            
        } else {
            // Si se accede a la ruta por GET, muestra el formulario de inicio de sesión
            return view('fyl/enroller/opsss');
        }
        
        
    }
    

    public function generarUUID()
    {
        // Genera un UUID versión 4 (aleatorio)
        $uuid = Uuid::uuid4();
    
        // Convierte el UUID a una cadena de texto para almacenarlo o utilizarlo como sea necesario
        $uuidString = $uuid->toString();
    
        // Retorna el UUID generado
        return $uuidString;
    }
    
    public function vigencia()
    {
        $fechaHoraActual = Carbon::now();

        // Agregar 8 minutos
        $fechaHoraActualMas8Minutos = $fechaHoraActual->addMinutes(8);
        
        // Formatear la fecha y hora resultante como una cadena
        $fechaHoraFormateada = $fechaHoraActualMas8Minutos->toDateTimeString();
        
        return $fechaHoraFormateada;
    }
    
    public function validacion(Request $request)
    {
        //return $request;
        $uuid = $request->clave;
        $codigo = $request->codigo;
        
        $crendentials = [
            'uuid' => $uuid,
            'password' => $codigo
            ];
        
        Auth::guard('alternative')->attempt($crendentials);
        
        
        $participant =  DB::select('CALL fyl_get_autenticacion_life(?,?)',[$uuid,$codigo]);
    
        if ($participant) {
            Session::put('authenticado', true);
            // Redirigir a la página de inicio
            return redirect()->intended('life/mi-entrenamiento')->with('participant', $participant)->with('status', 'Bienvenido!');
        } else {
            // Si la autenticación falla, redirigir de vuelta al formulario de inicio de sesión con un mensaje de error
            return redirect()->route('life')->with('error', 'Credenciales incorrectas');
        }
        
        

    }
    
    public function miEntrenamiento(Request $request)
    {
        if (Auth::check()) {
            // El usuario está autenticado
            if ($request->session()->exists()) {
                // Hay una sesión activa
                // Aquí puedes realizar cualquier acción adicional que desees
                // Por ejemplo, regenerar la sesión
                $request->session()->regenerate();
            } else {
                // No hay una sesión activa
            }
        } else {
            // El usuario no está autenticado
        }
        
        

        $participant = json_decode(json_encode($request->participant), true);

        return view('fyl/life/miEntrenamiento', ['participant' => $participant]);
    }

    public function show(Campus $Campus)
    {
        return view('fyl/campus/show',['Campus' => $Campus]);
    }

    public function edit(Campus $Campus)
    {
        
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy(Campus $Campus)
    {
    }


}
