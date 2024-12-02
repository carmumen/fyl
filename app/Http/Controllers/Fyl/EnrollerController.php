<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Code;
use App\Models\Fyl\IndividualCode;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Training;
use App\Models\Global\Catalog;
use App\Models\Global\City;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;

use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DateTime;

use Exception;

class EnrollerController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index',  'link', 'register']]);
    }


    public function index(Request $request)
    {

        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }
        
        $campusId = session('campusE') ?: 0;
        //return $campusId;
        
        

        session(['search' => $search]);

        $campus = DB::table('fyl_campus as c')
            ->join('fyl_campus_user as cu', 'cu.campus_id', '=', 'c.id')
            ->select('c.id', 'c.name')
            ->where ('cu.user_id', auth()->id())
            ->pluck('name','id');

        

            if (empty($requestData) && $campusId < 1) {
                //return 'campus 0';
                return view('fyl/enroller/enrollerLink', [
                    'campusId' => 0,
                    'campus' => $campus,
                ]);
            }
            else {
                //return $campusId ;
                $campusId = $request->campus_id ?: $campusId;

                $fechaActual = date('Y-m-d');
                $fechaHaceUnMes = date('Y-m-d', strtotime('-1 month', strtotime($fechaActual)));

                
                        
                $training = Training::where(function ($query) use ($fechaActual, $campusId) {
                            $query->where('end_date_focus', '<', $fechaActual)
                                  ->where('campus_id', $campusId)
                                  ->whereNotNull('team_name');
                            })
                            ->orWhere('number', 0)
                            ->orderByDesc('number')
                            ->orderBy('team_name')
                            ->pluck('team_name', 'id');
                        
                        

                $trainingInvited = Training::where('end_date_focus', '<', $fechaActual)
                        ->where('campus_id', $campusId)
                        ->whereNotNull('team_name')
                        ->select('id',
                                DB::Raw('CONCAT("FYL - ", number) as name')
                        )
                        ->orderByDesc('id') // Asegúrate de usar 'desc' con comillas simples
                        ->pluck('name', 'id');
                        
                        //return $trainingInvited;

                $participants = DB::table('fyl_participants_rezagados_view')
                        ->where('campus_id', $campusId)
                        ->get();
                        
                        //return $participants;
                
                $contador = 1;

                // Asignar el número secuencial a cada registro
                foreach ($participants as $participantsItem) {
                    $participantsItem->secuencial = $contador;
                    $contador++;
                }

                foreach ($participants as $participantsItem) {
                    $DNI = $participantsItem->DNI;

                    $hash = hash('sha256', $DNI); // Calcula el hash SHA-256
                    $hash = substr($hash, 0, 60);

                    $urlBase = config('app.url');

                    $fullUrl = $urlBase . '/registerRezagado/focus?opc=' . $hash;

                    // Actualiza el campo 'hash' para el participante
                    $participantsItem->url = $fullUrl;
                }

                return view('fyl/enroller/enrollerLink', [
                    'campusId' => $campusId,
                    'campus' => $campus,
                    'training' => $training,
                    'trainingInvited' => $trainingInvited,
                    'participant' => $participants
                ]);
            }

    }

    public function edit($id)
    {
        $userId = auth()->id();

        $training = DB::select('CALL fyl_get_training_user_edit(?)', [$userId]);
        
        

        $participants = Participants::findOrFail($id);
        $city = City::from('global_cities as CI')
            ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
            ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
            ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
            ->select(
                'CI.id',
                DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
            )
            ->where('CI.status', 'ACTIVO')
            ->groupby('CI.id', 'CO.name', 'P.name', 'CI.name')
            ->orderBy('CO.name', 'asc')
            ->orderBy('P.name', 'asc')
            ->orderBy('CI.name', 'asc')->pluck('name', 'id');
            
            //return $participants;
            
        $campus = DB::table('fyl_training as T')
            ->select(
                'T.campus_id'
            )
            ->where('T.id',$participants->training_id)
            ->first();
            
            
        session(['campusE' => $campus->campus_id]);

        $trainingEnroller = DB::select('CALL fyl_get_training_user_enroller()');

        return view('fyl/enroller/edit', [
            'training' => $training,
            'participants' => $participants,
            'training_enroler' => $trainingEnroller,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
            'cities' => $city,
        ]);
    }

    public function update(Request $request, $id)
    {
        $participants = Participants::findOrFail($id);

        $validatedData = Validator::make(
            $request->all(),
            [
                'DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                    Rule::unique('fyl_participants')->ignore($participants->id, 'id'),
                ],
                'names' => ['required', 'min:4'],
                'surnames' => ['required', 'min:4'],
                'nickname' => ['required'],
                'birthdate' => ['date','nullable'],
                'gender_catalog_id' => ['nullable'],
                'civil_status_catalog_id' => ['nullable'],
                'city_of_residence' => ['nullable'],
                'address' => ['nullable'],
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('fyl_participants')->ignore($participants->email, 'email'),
                ],
                'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'occupation' => ['nullable'],
                'emergency_contact' => ['nullable'],
                'emergency_contact_phone' => ['nullable', 'regex:/^[0-9]{8,13}$/'],
                'training_id_enroller' => ['nullable'],
                'DNI_enroller' => ['nullable'],
                'psychiatric_history' => ['nullable'],
                'psychiatric_history_details' => ['nullable'],
                'medical_history' => ['nullable'],
                'medical_history_details' => ['nullable'],
                'usual_medication' => ['nullable'],
                'usual_medication_details' => ['nullable'],
                'training_id' => ['required'],
                'status' => ['nullable'],
            ],
            $customMessages = []
        );

        if ($validatedData && $validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $dataUpdate = [
            'DNI' => $request->input('DNI'),
            'names' => $request->input('names'),
            'surnames' => $request->input('surnames'),
            'nickname' => $request->input('nickname'),
            'birthdate' => $request->input('birthdate'),
            'gender_catalog_id' => $request->input('gender_catalog_id'),
            'civil_status_catalog_id' => $request->input('civil_status_catalog_id'),
            'city_of_residence' => $request->input('city_of_residence'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'occupation' => $request->input('occupation'),
            'emergency_contact' => $request->input('emergency_contact'),
            'emergency_contact_phone' => $request->input('emergency_contact_phone'),
            'training_id_enroller' => $request->input('training_id_enroller'),
            'DNI_enroller' => $request->input('DNI_enroller'),
            'psychiatric_history' => $request->input('psychiatric_history'),
            'psychiatric_history_details' => $request->input('psychiatric_history_details'),
            'medical_history' => $request->input('medical_history'),
            'medical_history_details' => $request->input('medical_history_details'),
            'usual_medication' => $request->input('usual_medication'),
            'usual_medication_details' => $request->input('usual_medication_details'),
            'hash' => $hash,
            'training_id' => $request->input('training_id'),
            'status' => $request->input('status'),
            'user_id' => auth()->id()
        ];

        $participants->update($dataUpdate);

        return to_route('Enroller.index', $participants)->with('status', 'Participant updated!');
    }

    public function link()
    {
        $now = date('Y-m-d H:i:s');

        $training = DB::table('fyl_training as T')
            ->select(
                'T.id',
                DB::raw("COALESCE(CASE WHEN T.team_name = '' THEN NULL ELSE T.team_name END, CONCAT('LIFE ', T.number)) AS name")
            )
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->where(function ($query) use ($now) {
                $query->where('start_date_life', '<=', $now)
                    ->where('end_date_life', '>=', $now);
            })
            ->pluck('name', 'id');


        return view('fyl/enroller/enrollerLinkPublic', ['training' => $training]);
    }

    public function filter(Request $request)
    {
        $categoriaId = $request->input('training_id');

        return view('vista', compact('productos'));
    }
    

    public function code(Request $request)
    {
        $participants = DB::table('fyl_participants')
            ->select('DNI')
            ->whereRaw('LENGTH(DNI) > 1')
            ->whereNull('hash')
            ->get();

        foreach ($participants as $participant) {
            $DNI = $participant->DNI;

            $hash = hash('sha256', $DNI); // Calcula el hash SHA-256
            $hash = substr($hash, 0, 60);

            // Actualiza el campo 'hash' para el participante
            DB::table('fyl_participants')
                ->where('DNI', $DNI)
                ->update(['hash' => $hash]);
        }


        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $data = $this->data();

        return view('fyl/enroller/code', $data);
    }

    function data() {
        $userId = auth()->id();

        $campusIds = DB::table('fyl_campus')
            ->join('fyl_campus_user', 'fyl_campus.id', '=', 'fyl_campus_user.campus_id')
            ->where('fyl_campus_user.user_id', $userId)
            ->select('fyl_campus.id', 'fyl_campus.name')
            ->pluck('name', 'id');

        $campusIdValues = $campusIds->keys()->toArray();

        $date = date('Y-m-d');
        

        //return $date;
        $urlBase = config('app.url') . '/generate/focus?opc=';

        $code = DB::select('CALL fyl_get_code_active(?,?)', [$userId,$urlBase]);

            $data = [
                'campus' => $campusIds,
                'code' => $code
            ];

            return $data;

    }

    public function generateCode(Request $request)
    {
       //return $request;
        $validatedData = Validator::make(
            $request->all(),
            [
                'campus_id' => ['required'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date'],
            ]
        );

        if ($validatedData && $validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $campusId = $request->input('campus_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $result = DB::select('CALL fyl_code_count(?,?,?)', [$campusId, $startDate, $endDate]);

        $outputCount = collect($result)->toArray();

       //return $outputCount[0]->count;

        if ($outputCount[0]->count > 0) {
            return redirect()->back()->withErrors(['errors' => 'Error. Existe uno o varios registros para las fechas seleccionadas.']);
        }

        $currentDate = date('Y-m-d H:i:s');  // Obtiene la fecha y hora actual

        $userId = auth()->id();

        $result1 = DB::select('CALL fyl_training_for_code(?,?)', [$campusId,$userId ]);

        $training = collect($result1);

        $new_training = DB::table('fyl_next_training_focus_view')
                        ->where('campus_id',$campusId)
                        ->select('id')
                        ->first();


        foreach ($training as $trainingItem) {
            $team = $currentDate . strval($trainingItem->id);
            $hashedDate = hash('sha256', $team);
            $tablaCode = [
                'campus_id' => $campusId,
                'training_id_enroller' => $trainingItem->id,
                'training_id' => $new_training->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'code' => $hashedDate,
                'user_id' => $userId
            ];

            Code::create($tablaCode);
        }

        $data = $this->data();

        return view('fyl/enroller/code', $data);
    }

    public function generate(Request $request)
    {
        $opc = $request->opc;
        
        

        $participants = DB::table('fyl_enrollment_code AS ec')
            ->join('fyl_life_participants AS lp', 'ec.training_id_enroller', '=', 'lp.training_id')
            ->join('fyl_participants AS p', 'lp.participant_DNI', '=', 'p.DNI')
            ->selectRaw('MAX(lp.level) as level, lp.training_id, p.hash as id, CONCAT(p.surnames, " ", p.names) as name')
            ->where('ec.code', '=', $opc)
            ->groupBy('lp.training_id', 'p.DNI', 'p.surnames', 'p.names', 'p.hash')
            ->orderBy('p.surnames')
            ->orderBy('p.names')
            ->pluck('name', 'id');
            
            //return $participants;

        if ($participants->count() == 0) {
            return view('fyl/enroller/opsss');
        }

        return view('fyl/enroller/generateLink', [
            'participant' => $participants,
            'opc' => $opc,
        ]);
    }


    public function register(Request $request)
    {
        $opc = $request->opc;
        $participant = $request->participant;

        $participants = DB::table('fyl_enrollment_code AS ec')
            ->join('fyl_life_participants AS lp', 'ec.training_id_enroller', '=', 'lp.training_id')
            ->join('fyl_participants AS p', 'lp.participant_DNI', '=', 'p.DNI')
            ->selectRaw('MAX(lp.level) as level, lp.training_id, p.hash as id, CONCAT(p.surnames, " ", p.names) as name')
            ->where('ec.code', '=', $opc)
            ->groupBy('lp.training_id', 'p.DNI', 'p.surnames', 'p.names', 'p.hash')
            ->orderBy('p.surnames')
            ->orderBy('p.names')
            ->pluck('name', 'id');
        //return $participants;

        if ($participants->count() == 0) {
            return view('fyl/enroller/opsss');
        }

        $urlBase = config('app.url') . '/inscription/focus?';

        $params = [
            'opc' => $opc,
            'a' => $participant,
        ];

        $fullUrl = $urlBase . http_build_query($params);

        return view('fyl/enroller/generateLink', [
            'participant' => $participants,
            'opc' => $opc,
            'par' => $participant,
            'link' => $fullUrl
        ]);
    }

    public function registerRezagado(Request $request)
    {
        $opc = $request->opc;

        $participants = DB::table('fyl_participants')
            ->where('hash', '=', $opc)
            ->orderBy('surnames')
            ->orderBy('names')
            ->first();

        if (empty($participants)) {
            return view('fyl/enroller/opsss');
        }

        return view('fyl/enroller/registerRezagado', [
            'participant' => $participants,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
        ]);
    }

    public function registerNameChange(Request $request)
    {
        $opc = $request->opc;

        $participants = DB::table('fyl_participants')
            ->where('hash', '=', $opc)
            ->orderBy('surnames')
            ->orderBy('names')
            ->first();

        if (empty($participants)) {
            return view('fyl/enroller/opsss');
        }

        return view('fyl/enroller/registerNameChange', [
            'participant' => $participants,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
        ]);
    }

    public function inscription(Request $request)
    {
        
        $code = $request->opc;
        $hashDNI = $request->a;

        $training = Code::where('code', $code)->first();
        
        
        $participant = Participants::where('hash', $hashDNI)->first();
        
        $campus = Campus::where('id',$training->campus_id)->first();
        
        $campus_id = $campus->id;
        
        $price = DB::table('fyl_life_participants')
                            ->where('participant_DNI', $participant->DNI)
                            ->where('training_id', $training->training_id_enroller)
                            ->orderByDesc('level')
                            ->limit(1)
                            ->selectRaw('CASE role 
                                                WHEN "MASTER LIFE" THEN (SELECT price FROM fyl_prices WHERE catalogo_id_price_type = 70 LIMIT 1)
                                                WHEN "PARTICIPANTE" THEN (SELECT price FROM fyl_prices WHERE catalogo_id_price_type = 71 LIMIT 1)
                                                ELSE (SELECT price FROM fyl_prices WHERE catalogo_id_price_type = 69 LIMIT 1)
                                            END AS price')
                            ->value('price');
            
        $training_dates = DB::table('fyl_training')->where('id',$training->training_id)->first();
        
        $start_date = new DateTime($training_dates->start_date_focus);
        $end_date = new DateTime($training_dates->end_date_focus);
            
        $fechaH = $this->fecha_humana($start_date, $end_date);
         
        $data = [
            'campus' => $campus,
            'campus_id' => $campus_id,
            'price' => $price,
            'training_id_enroller' => $training->training_id_enroller,
            'training_id' => $training->training_id,
            'DNI_enroller' => $participant->DNI,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
            'fechaH' => 'FOCUS '.$fechaH,
            ];
            
           // return $data;

        return view('fyl/enroller/registerParticipant', $data);
    }
    
    

    public function inscriptionL(Request $request)
    {
        //return $request->opc;
        $startDate = date('Y-m-d H:i:s');

        $code = DB::table('fyl_enrollment_individual_code')
                    ->where('code',$request->opc)
                    ->where('end_date', '>', $startDate)
                    ->first();
                    
        //return $code;

        if (empty($code)) {
            return view('fyl/enroller/opsss');
        }
        
        $campus = Campus::where('id',1)->first();
        
        $campus_id = $campus->id;
        
        //return $campus_id;
        
        $price = DB::table('fyl_prices')
                        ->where('campus_id', 1)
                        ->where('programs_included', 'F')
                        ->where('catalogo_id_price_type', 70)
                        ->first()
                        ->price;
                        
        $training_dates = DB::table('fyl_training')->where('id',$code->training_id)->first();
        
        $start_date = new DateTime($training_dates->start_date_focus);
        $end_date = new DateTime($training_dates->end_date_focus);
            
        $fechaH = $this->fecha_humana($start_date, $end_date);
        
        $data = [
            'campus' => $campus,
            'campus_id' => $campus_id,
            'price' => $price,
            'training_id_enroller' => $code->training_id_enroller,
            'training_id' => $code->training_id,
            'DNI_enroller' => $code->DNI_enroller,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
            'fechaH' => 'FOCUS '.$fechaH,
            ];
        
        //return $data;

        return view('fyl/enroller/registerParticipant', $data);
    }
    
    public function fecha_humana($start_date, $end_date) {
        // Establecer configuración regional en español
        setlocale(LC_TIME, 'es_ES.UTF-8');
    
        $start_day = $start_date->format('d');
        $end_day = $end_date->format('d');
        $start_month = $start_date->format('m');
        $end_month = $end_date->format('m');
        $start_year = $start_date->format('Y');
        $end_year = $end_date->format('Y');
    
        // Construir la cadena de texto según las condiciones dadas
        if ($start_year == $end_year && $start_month == $end_month) {
            // Mismo mes y mismo año
            $fechaH = "del $start_day al $end_day de " . strftime('%B', $start_date->getTimestamp()) . " de $start_year";
        } elseif ($start_year == $end_year) {
            // Mismo año, diferente mes
            $fechaH = "del $start_day de " . strftime('%B', $start_date->getTimestamp()) . " al $end_day de " . strftime('%B', $end_date->getTimestamp()) . " de $start_year";
        } else {
            // Diferente año
            $fechaH = "del $start_day de " . strftime('%B', $start_date->getTimestamp()) . " de $start_year al $end_day de " . strftime('%B', $end_date->getTimestamp()) . " de $end_year";
        }
    
        // Restaurar la configuración regional a la configuración predeterminada
        setlocale(LC_TIME, NULL);
    
        // $fechaH contendrá el formato deseado
        return $fechaH;
    }
    
    
    private function validateCedulaEcuador($cedula)
    {
        if (strlen($cedula) !== 10) {
            return false;
        }

        $coeficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $result = $cedula[$i] * $coeficients[$i];
            $sum += $result > 9 ? $result - 9 : $result;
        }

        $calculatedLastDigit = ($sum % 10 === 0) ? 0 : 10 - ($sum % 10);
        $lastDigit = intval(substr($cedula, -1));

        return $lastDigit === $calculatedLastDigit;
    }
    
    public function validarCedulaEcuatoriana($cedula) {
        $cedula = str_replace([' ', '-'], '', $cedula);
        
        if (strlen($cedula) !== 10 || !is_numeric($cedula)) {
            return false;
        }
        
        $verificador = (int)substr($cedula, 9, 1);
        
        $suma = 0;
        for ($i = 0; $i < 9; $i++) {
            $valor = (int)$cedula[$i];
    
            if ($i % 2 === 0) {
                $valor *= 2;
    
                if ($valor > 9) {
                    $valor -= 9;
                }
            }
    
            $suma += $valor;
        }
        
        $digitoVerificador = 10 - ($suma % 10);
        
        if ($digitoVerificador === 10) {
            $digitoVerificador = 0;
        }
    
        return $digitoVerificador === $verificador;
    }
    

    public function form(Request $request)
    {
        //return $request;
        $validatedData = Validator::make(
            $request->all(),
            [
                'tipo_identidad' => ['required'],
                'DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                    Rule::unique('fyl_participants')->ignore($request->input('DNI'), 'DNI'),
                ],
                'names' => ['required', 'min:4'],
                'surnames' => ['required', 'min:4'],
                'nickname' => ['required'],
                'birth_year' => ['required'],
                'birth_month' => ['required'],
                'birth_day' => ['required'],
                'gender_catalog_id' => ['required'],
                'civil_status_catalog_id' => ['required'],
                'city_of_residence' => ['required'],
                'address' => ['required'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('fyl_participants')->ignore($request->input('email'), 'email'),
                ],
                'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'occupation' => ['required'],
                'emergency_contact' => ['required'],
                'emergency_contact_phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'training_id_enroller' => ['required'],
                'training_id' => ['required'],
                'DNI_enroller' => ['required'],
                'psychiatric_history' => ['required'],
                'psychiatric_history_details' => ['nullable'],
                'medical_history' => ['required'],
                'medical_history_details' => ['nullable'],
                'usual_medication' => ['required'],
                'usual_medication_details' => ['nullable'],
                'aceptollamadas' => ['required'],
                
                'fac_tipo_identidad' => ['required'],
                'fac_DNI' => ['required'],
                'fac_razon_social' => ['required'],
                'fac_email' => ['required'],
                'fac_direccion' => ['required'],
                'fac_telefono' => ['required'],
                
            ]
        );
        
        $validatedData->after(function ($validator) use ($request) {
            if(($request->input('campus_id') == 1 || $request->input('campus_id') == 2) && $request->input('tipo_identidad') == 'CEDULA')
            {
                if(!$this->validarCedulaEcuatoriana($request->input('DNI'))){
                    $validator->errors()->add('DNI', 'Identidad NO válida.');
                }
            } 
        });
        
        $validatedData->after(function ($validator) use ($request) {
            if(($request->input('campus_id') == 1 || $request->input('campus_id') == 2) && $request->input('fac_tipo_identidad') == 'CEDULA')
            {
                if(!$this->validarCedulaEcuatoriana($request->input('fac_DNI'))){
                    $validator->errors()->add('fac_DNI', 'Identidad NO válida.');
                }
            } 
        });

        $validatedData->after(function ($validator) use ($request) {
            $existingDNI = Participants::where('DNI', $request->input('DNI'))->first();
            if ($existingDNI) {
                $validator->errors()->add('DNI', 'El Número de cédula ya se encuentra registrado');
            }
        });

        $validatedData->after(function ($validator) use ($request) {
            $existingEmail = Participants::where('email', $request->input('email'))->first();
            if ($existingEmail) {
                $validator->errors()->add('email', 'El email ya se encuentra registrado');
            }
        });

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            // Imprime los errores para conocerlos
            //dd($errors);
            return redirect()->back()->withErrors($errors)->withInput();
        }


        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $birthdate = $request->input('birth_year') . '-' . $request->input('birth_month') . '-' . $request->input('birth_day');

        $_training_id = $request->training_id_enroller;
        

        $dataCreate = [
            'training_id_original' => $request->input('training_id'),
            'tipo_identidad' => $request->input('tipo_identidad'),
            'DNI' => $request->input('DNI'),
            'names' => $request->input('names'),
            'surnames' => $request->input('surnames'),
            'nickname' => $request->input('nickname'),
            'birthdate' => $birthdate,
            'gender_catalog_id' => $request->input('gender_catalog_id'),
            'civil_status_catalog_id' => $request->input('civil_status_catalog_id'),
            'city_of_residenceT' => $request->input('city_of_residence'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'phone2' => $request->input('phone2'),
            'occupation' => $request->input('occupation'),
            'emergency_contact' => $request->input('emergency_contact'),
            'emergency_contact_phone' => $request->input('emergency_contact_phone'),
            'training_id_enroller' => $request->input('training_id_enroller'),
            'DNI_enroller' => $request->input('DNI_enroller'),
            'psychiatric_history' => $request->input('psychiatric_history'),
            'psychiatric_history_details' => $request->input('psychiatric_history_details'),
            'medical_history' => $request->input('medical_history'),
            'medical_history_details' => $request->input('medical_history_details'),
            'usual_medication' => $request->input('usual_medication'),
            'usual_medication_details' => $request->input('usual_medication_details'),
            'hash' => $hash,
            'training_id' => $request->input('training_id'),
            'status' => 'ACTIVE',
            'user_id' => auth()->id(),
            'fac_tipo_identidad' => $request->input('fac_tipo_identidad'),
            'fac_DNI' => $request->input('fac_DNI'),
            'fac_razon_social' => $request->input('fac_razon_social'),
            'fac_email' => $request->input('fac_email'),
            'fac_direccion' => $request->input('fac_direccion'),
            'fac_telefono' => $request->input('fac_telefono'),
        ];
            

        Participants::create($dataCreate);

        return view('fyl/enroller/congratulations');
    }
    
    public function formChange(Request $request)
    {
        $participants = Participants::findOrFail($request->id);
        
        DB::table('fyl_focus_participants')->where('participant_DNI', '=', $participants->DNI)->delete();
        
        $validatedData = Validator::make(
            $request->all(),
            [
                'DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                    Rule::unique('fyl_participants')->ignore($request->input('DNI'), 'DNI'),
                ],
                'names' => ['required', 'min:4'],
                'surnames' => ['required', 'min:4'],
                'nickname' => ['required'],
                'birth_year' => ['required'],
                'birth_month' => ['required'],
                'birth_day' => ['required'],
                'gender_catalog_id' => ['required'],
                'civil_status_catalog_id' => ['required'],
                'city_of_residence' => ['required'],
                'address' => ['required'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('fyl_participants')->ignore($request->input('email'), 'email'),
                ],
                'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'occupation' => ['required'],
                'emergency_contact' => ['required'],
                'emergency_contact_phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'training_id_enroller' => ['required'],
                'training_id' => ['required'],
                'DNI_enroller' => ['required'],
                'psychiatric_history' => ['required'],
                'psychiatric_history_details' => ['nullable'],
                'medical_history' => ['required'],
                'medical_history_details' => ['nullable'],
                'usual_medication' => ['required'],
                'usual_medication_details' => ['nullable'],
            ]
        );
        
        $campus = Training::where('id', $request->input('training_id'))->first();
        
        $validatedData->after(function ($validator) use ($request, $campus) {
            if(($campus->campus_id == 1 || $campus->campus_id == 2) && $request->input('tipo_identidad') == 'CEDULA')
            {
                if(!$this->validarCedulaEcuatoriana($request->input('DNI'))){
                    $validator->errors()->add('DNI', 'Identidad NO válida.');
                }
            } 
        });

        $validatedData->after(function ($validator) use ($request) {
            $existingDNI = Participants::where('DNI', $request->input('DNI'))->first();
            if ($existingDNI) {
                $validator->errors()->add('DNI', 'El Número de cédula ya se encuentra registrado');
            }
        });

        $validatedData->after(function ($validator) use ($request) {
            $existingEmail = Participants::where('email', $request->input('email'))->first();
            if ($existingEmail) {
                $validator->errors()->add('email', 'El email ya se encuentra registrado');
            }
        });

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $birthdate = $request->input('birth_year') . '-' . $request->input('birth_month') . '-' . $request->input('birth_day');

        $_training_id = $request->training_id_enroller;
        
        DB::select('CALL update_fyl_participants_change_name(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', 

        [
            $request->id,
            $request->input('tipo_identidad'),
            $request->input('DNI'),
            $request->input('names'),
            $request->input('surnames'),
            $request->input('nickname'),
            $birthdate,
            $request->input('gender_catalog_id'),
            $request->input('civil_status_catalog_id'),
            $request->input('city_of_residence'),
            $request->input('address'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('phone2'),
            $request->input('occupation'),
            $request->input('emergency_contact'),
            $request->input('emergency_contact_phone'),
            $request->input('training_id_enroller'),
            $request->input('DNI_enroller'),
            $request->input('psychiatric_history'),
            $request->input('psychiatric_history_details'),
            $request->input('medical_history'),
            $request->input('medical_history_details'),
            $request->input('usual_medication'),
            $request->input('usual_medication_details'),
            $request->input('training_id'),
            $hash,
            'ACTIVE',
            'SI',
            auth()->id()
        ]
        );
        
        //return $dataUpdate;

        //$participants->update($dataUpdate);

        return view('fyl/enroller/congratulations');
    }

    public function formRezagado(Request $request)
    {
        //return $request;
        $validatedData = Validator::make(
            $request->all(),
            [
                'DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                    Rule::unique('fyl_participants')->ignore($request->input('DNI'), 'DNI'),
                ],
                'names' => ['required', 'min:4'],
                'surnames' => ['required', 'min:4'],
                'nickname' => ['required'],
                'birth_year' => ['required'],
                'birth_month' => ['required'],
                'birth_day' => ['required'],
                'gender_catalog_id' => ['required'],
                'civil_status_catalog_id' => ['required'],
                'city_of_residenceT' => ['required'],
                'address' => ['required'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('fyl_participants')->ignore($request->input('email'), 'email'),
                ],
                'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'occupation' => ['required'],
                'emergency_contact' => ['required'],
                'emergency_contact_phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'training_id_enroller' => ['required'],
                'DNI_enroller' => ['required'],
                'psychiatric_history' => ['required'],
                'psychiatric_history_details' => ['nullable'],
                'medical_history' => ['required'],
                'medical_history_details' => ['nullable'],
                'usual_medication' => ['required'],
                'usual_medication_details' => ['nullable'],
            ]
        );
        
        $campus = Training::where('id', $request->input('training_id'))->first();
        
        $validatedData->after(function ($validator) use ($request, $campus) {
            if(($campus->campus_id == 1 || $campus->campus_id == 2) && $request->input('tipo_identidad') == 'CEDULA')
            {
                if(!$this->validarCedulaEcuatoriana($request->input('DNI'))){
                    $validator->errors()->add('DNI', 'Identidad NO válida.');
                }
            } 
        });

        $validatedData->after(function ($validator) use ($request) {
            $existingDNI = Participants::where('DNI', $request->input('DNI'))->where('id', '<>', $request->input('id'))->first();
            if ($existingDNI) {
                $validator->errors()->add('DNI', 'El Número de cédula ya se encuentra registrado');
            }
        });

        $validatedData->after(function ($validator) use ($request) {
            $existingEmail = Participants::where('email', $request->input('email'))->where('id', '<>', $request->input('id'))->first();
            if ($existingEmail) {
                $validator->errors()->add('email', 'El email ya se encuentra registrado');
            }
        });

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $birthdate = $request->input('birth_year') . '-' . $request->input('birth_month') . '-' . $request->input('birth_day');


        $dataCreate = [
            'tipo_identidad' => $request->input('tipo_identidad'),
            'DNI' => $request->input('DNI'),
            'names' => $request->input('names'),
            'surnames' => $request->input('surnames'),
            'nickname' => $request->input('nickname'),
            'birthdate' => $birthdate,
            'gender_catalog_id' => $request->input('gender_catalog_id'),
            'civil_status_catalog_id' => $request->input('civil_status_catalog_id'),
            'city_of_residenceT' => $request->input('city_of_residence'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'phone2' => $request->input('phone2'),
            'occupation' => $request->input('occupation'),
            'emergency_contact' => $request->input('emergency_contact'),
            'emergency_contact_phone' => $request->input('emergency_contact_phone'),
            'training_id_enroller' => $request->input('training_id_enroller'),
            'DNI_enroller' => $request->input('DNI_enroller'),
            'psychiatric_history' => $request->input('psychiatric_history'),
            'psychiatric_history_details' => $request->input('psychiatric_history_details'),
            'medical_history' => $request->input('medical_history'),
            'medical_history_details' => $request->input('medical_history_details'),
            'usual_medication' => $request->input('usual_medication'),
            'usual_medication_details' => $request->input('usual_medication_details'),
            'hash' => $hash,
            'training_id' => $request->input('training_id'),
            'status' => 'ACTIVE',
            'user_id' => auth()->id()
        ];

        $participant = Participants::find($request->id);

        $participant->update($dataCreate);

        $exists = DB::table('fyl_payment_participant')->where('participant_DNI', $request->DNI_old)->first();

        if ($exists) {
            DB::table('fyl_payment_participant')
                ->where('participant_DNI', $request->DNI_old)
                ->update(['participant_DNI' => $request->DNI]);
        }


        DB::select('CALL insert_focus_participants_recovered(?,?,?)', [
            $request->input('training_id'), 
            $request->input('DNI'), 
            auth()->id()
        ]);

        return view('fyl/enroller/congratulations');
    }

    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }

    public function internalCode()
    {
        //return 'Si';
        $userId = auth()->id();

        $training_id = $this->getTrainingNext();

        $trainingEnroller = DB::table('fyl_trainings_old_view')->where('user_id', $userId)->get();
        
        $data = [
            'user_id' => $userId,
            'trainingId' => 0,
            'trainingEnroller' => $trainingEnroller,
            'training_id' => $training_id
            ];

        //return $data;
        return view('fyl/enroller/internal-code',$data);
    }

    public function generateInternalCode(Request $request)
    {
        $startDate = date('Y-m-d H:i:s'); // Obtiene la hora actual en formato 'Y-m-d H:i:s'
        $endDate = date('Y-m-d H:i:s', strtotime($startDate . ' +2 hours')); // Suma 2 horas a la hora actual

        $userId = auth()->id();

        $urlBase = config('app.url');

        $training_id = $this->getTrainingNext();


        $DNI_enroller = $request->DNI_enroller;
        $trainingId = $request->training_id;
        $campusId = DB::table('fyl_training')->select('campus_id')->where('id',$trainingId)->first();

        $trainingEnroller = DB::table('fyl_trainings_old_view')->where('user_id', $userId)->get();
        
    

        $exists = DB::table('fyl_enrollment_individual_code')
                    ->where('campus_id', $campusId->campus_id)
                    ->where('training_id_enroller', $request->training_id_enroller)
                    ->where('training_id', $request->training_id)
                    ->where('DNI_enroller', $request->DNI_enroller)
                    ->where('end_date', '>', $startDate)
                    ->selectRaw('TIMEDIFF(DATE_SUB(NOW(), INTERVAL 5 HOUR),end_date) as time_diff, code, end_date, TIME(end_date) as time')
                    ->first();

        if ($exists) {
            $timeDiff = Carbon::parse($exists->time_diff);
            $hours = $timeDiff->format('H');
            $minutes = $timeDiff->format('i');

            $link = $urlBase . '/inscriptionL/focus?opc=' . $exists->code;

            return view('fyl/enroller/internal-code',[
                'error' => 'Su enlace estará activo hasta las '. $exists->time,
                'trainingId' => $trainingId,
                'trainingEnroller' => $trainingEnroller,
                'training_id' => $training_id,
                'link' => $link,
            ]);
        }

        //return $request;

        $team = $startDate . strval($trainingId);
        $hashedDate = hash('sha256', $team);
        $hashedDate = substr($hashedDate, 0, 60);

        $tablaCode = [
            'campus_id' => $campusId->campus_id,
            'training_id' => $request->training_id,
            'training_id_enroller' =>  $request->training_id_enroller,
            'DNI_enroller' => $request->DNI_enroller,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'code' => $hashedDate,
            'user_id' => $userId
        ];

        //return $tablaCode;

        IndividualCode::create($tablaCode);


        $link = $urlBase . '/inscriptionL/focus?opc=' . $hashedDate;

        return view('fyl/enroller/internal-code',[
            'trainingId' => $trainingId,
            'trainingEnroller' => $trainingEnroller,
            'training_id' => $training_id,
            'link' => $link,
        ]);
    }

    public function newRegister(Request $request)
    {
        $training_enroller = DB::table('fyl_training')->where('id',$request->input('training_id_enroller'))->first();
        
        //return $training_enroller;
        
        $validatedData = Validator::make(
            $request->all(),
            [
                'training_id_enroller' => ['required'],
                'DNI_enroller' => ['required'],
                'training_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request,$training_enroller) {
                        $trainingIdEnroller = $request->input('training_id_enroller');
                        if ($value <= $trainingIdEnroller && $training_enroller->number != 0) {
                            $fail('El campo ' . $attribute . ' debe ser mayor que el equipo enrolador.');
                        }
                    },
                ],
            ]
        );


        if ($validatedData && $validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $DNI = date('mdHis');

        $hash = hash('sha256', $DNI); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $dataCreate = [
            'training_id_original' => $request->input('training_id'),
            'DNI' => $DNI,
            'names' => $request->input('names'),
            'surnames' => 'Apellidos',
            'nickname' => '',
            'training_id_enroller' => $request->input('training_id_enroller'),
            'DNI_enroller' => $request->input('DNI_enroller'),
            'training_id' => $request->input('training_id'),
            'payment_status_focus' => 'PAGO TOTAL',
            'graduate' => 'NO',
            'hash' => $hash,
            'status' => 'ACTIVE',
            'user_id' => auth()->id()
        ];

        Participants::create($dataCreate);

        return to_route('Enroller.index', ['campus_id' => $request->input('campusId')])->with('status', 'Participant create!');
    }
}
