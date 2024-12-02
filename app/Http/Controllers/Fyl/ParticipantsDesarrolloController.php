<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Global\Catalog;
use App\Models\Global\City;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Training;
use App\Models\Fyl\Programs;
use App\Models\Fyl\Prices;
use App\Models\Fyl\Payment;
use App\Models\Fyl\Clients;
use App\Models\Fyl\Campus;
use App\Models\Users;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Exception;

class ParticipantsDesarrolloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        //return $request;
        
        $search_participant = $request->input('search') ?: '%';
        $search_participant = str_replace(' ', '%', $search_participant);
        
        if ($search_participant == '') {
            $search_participant = session('search_participant');
        }
        
        session(['search_participant' => $search_participant]);
        
        $requestData = $request->all();
        
        $userId = auth()->id();
        
        $campuses = Users::find($userId)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');

        if (empty($requestData)) {
            
            $dataInicio = [
                'campus' => $campuses,
                'campusId' => 0, 
                'trainingId' => 0, 
                'parameter' => 'P',
                'search' => '',
                'pag' => 15,
            ];
            //return $dataInicio;
            return view('fyl/participants_desarrollo/index', $dataInicio);
        }
        
        
        //$campusId = $request->campus_id;
        
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        $parameter = $request->input('parameter') ?: 'P';
        $pag = $request->input('pag') ?: 15;
        
        $participantes = Participants::whereNull('password')->get();

        // Itera sobre cada registro
        foreach ($participantes as $participante) {
            // Genera el hash de la cédula y actualiza el campo 'password'
            $participante->update(['password' => Hash::make($participante->DNI)]);
        }
                    
        $trainings = DB::table('fyl_participants as p')
                    ->leftJoin('fyl_training as t', 'p.training_id_enroller', '=', 't.id')
                    ->select('t.id', DB::raw("COALESCE(t.team_name, CONCAT('FYL - ', t.number)) as name"))
                    ->where('t.campus_id', $campusId)
                    ->whereNotNull('p.training_id_enroller')
                    ->distinct()
                    ->orderby('t.id','DESC')
                    ->pluck('name','t.id');
        
        $participants = [];
        
        //fyl_get_participants(3, 0, 'P', '', 50)
        
        $search = str_replace(' ', '%', $search_participant);
        
        $dataBusca = [
            $campusId, 
            $trainingId, 
            $parameter, 
            $search, 
            $pag
            ];
        
        $participants = DB::select('CALL fyl_get_participants(?,?,?,?,?)', $dataBusca);
        
        // Inicializar el contador
        $contador = 1;// ($participants->currentPage() - 1) * $participants->perPage() + 1;

        // Asignar el número secuencial a cada registro
        foreach ($participants as $participantsItem) {
            $participantsItem->secuencial = $contador;
            $participantsItem->usuario = $userId;
            $contador++;
            $participantsItem->valida = 0;
            if($participantsItem->campus_id == 1)
            {
                if($this->validarCedulaEcuatoriana($participantsItem->DNI))
                    $participantsItem->valida = 1;
            }
        }
        
        $data = [
            'campus' => $campuses,
            'campusId' => $campusId,
            'training' => $trainings,
            'trainingId' => $trainingId,
            'parameter' => $parameter,
            'participant' => $participants,
            'search' => $search_participant, 
            'pag' => $pag
        ];
        
        
        return view('fyl/participants_desarrollo/index', $data);
        
    }
    
    public function obtenerEntrenamiento(Request $request)
    {
        $campusId = $request->input('campus_id') ?: 0;
        $trainingId = $request->input('training_id') ?: 0;
        $parameter = $request->input('parameter') ?: 'P';
        $search = $request->input('search') ?: '%';
        $pag = $request->input('pag') ?: 15;
        
        $data = [
            'campus_id' => $campusId,
            'training_id' => $trainingId,
            'parameter' => $parameter,
            'search' => $search,
            'pag' => $pag
            ];
            
            //return $data;
        
        return to_route('Participants.index', $data);
        
    }
    
    public function recarga(Request $request)
    {
        $campus_id =  $request->campus_id;
        $training_id = $request->training_id;
        
        return to_route('Participants.index', ['campus_id' => $campus_id,'training_id' => $training_id]);
        
    }
    
    public function retorno(Request $request)
    {
        $campus_id =  $request->campusId;
        $training_id = $request->trainingId;
        
        return to_route('Participants.index', ['campus_id' => $campus_id,'training_id' => $training_id]);
        
    }
    
    public function training_in_game(Request $request)
    {
        $campusId = $request->campusId;
        
        return DB::table('fyl_training')
                    ->where('campus_id', $campusId)
                    ->whereNotNull('start_date_life')
                    ->orderBy('id','DESC')
                    ->limit(5)
                    ->pluck(\DB::raw("COALESCE(team_name, CONCAT('FYL - ', number)) as name"), 'id');
    }
    
    
    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }
    

    private function getNextTraining($campusId)
    {
        $nextTraining = DB::table('fyl_next_training_view')
            ->select('TRAINING')
            ->where("campus_id", "=", $campusId)
            ->orderby('startDate')
            ->take(1)
            ->first(); // Usar first() para obtener solo un registro, en lugar de get()

        // Verificar si se encontró algún resultado
        if ($nextTraining) {
            return $nextTraining->TRAINING; // Devolver solo el valor TRAINING
        } else {
            return ''; // O un valor predeterminado si no se encuentra ningún registro
        }
    }


    public function create()
    {
        $userId = auth()->id();

        $training = DB::select('CALL fyl_get_training_user_new(?)', [$userId]);

        $city = City::from('global_cities as CI')
            ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
            ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
            ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
            ->select(
                'CI.id',
                DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
            )
            ->where('CI.status', '=', 'ACTIVO')
            ->groupby('CI.id', 'CO.name', 'P.name', 'CI.name')
            ->orderBy('CO.name', 'asc')
            ->orderBy('P.name', 'asc')
            ->orderBy('CI.name', 'asc')->pluck('name', 'id');

        $trainingEnroller = DB::select('CALL fyl_get_training_user_enroller()');

        return view('fyl/participants/create', [
            'training' => $training,
            'participants' => new Participants,
            'training_enroler' => $trainingEnroller,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
            'payment_method' => Catalog::where('catalog_types_id', 4)->pluck('name', 'id'),
            'card' => Catalog::where('catalog_types_id', 5)->pluck('name', 'id'),
            'tipoPago' => Catalog::where('catalog_types_id', 6)->pluck('name', 'id'),
            'bank' => Catalog::where('catalog_types_id', 8)->pluck('name', 'id'),
            'cities' => $city,
        ]);
    }


    public function store(Request $request)
    {
        $search_participant = $request->input('search_participant');
        $pag = $request->input('pag') ?: 10;

        $validatedData = Validator::make(
            $request->all(),
            [
                'DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                    Rule::unique('fyl_participants')->ignore($request->input('DNI')),
                ],
                'names' => ['required', 'min:4'],
                'surnames' => ['required', 'min:4'],
                'nickname' => ['required'],
                'birthdate' => ['nullable'],
                'gender_catalog_id' => ['nullable'],
                'civil_status_catalog_id' => ['nullable'],
                'city_of_residence' => ['nullable'],
                'address' => ['nullable'],
                'email' => ['required', 'string', 'email', 'max:255'],
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
            ]
        );


        if ($validatedData && $validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $dataCreate = [
            'training_id_original' => $request->input('training_id'),
            'DNI' => $request->input('DNI'),
            'names' => $request->input('names'),
            'surnames' => $request->input('surnames'),
            'nickname' => $request->input('nickname'),
            'birthdate' => $request->input('birthdate'),
            'gender_catalog_id' => $request->input('gender_catalog_id'),
            'civil_status_catalog_id' => $request->input('civil_status_catalog_id'),
            'city_of_residenceT' => $request->input('city_of_residence'),
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
            'training_id' => $request->input('training_id'),
            'hash' => $hash,
            'status' => $request->input('status'),
            'user_id' => auth()->id()
        ];

        Participants::create($dataCreate);
        
        $training_id =  $request->input('training_id');
        
        $campus_id = DB::table('fyl_training')->where('id',$training_id)->first();
        
        return to_route('Participants.index', ['campus_id' => $campus_id,'training_id' => $training_id])->with('status', 'Participant create!');

        //return to_route('Participants.index')->with('status', 'Participant create!');
    }

    public function show($Training)
    {
        //return view('fyl/training/show', ['Training' => $Training]);
    }

    public function edit($id,$campusId,$trainingId)
    {

        $userId = auth()->id();

        $training = DB::select('CALL fyl_get_training_user_edit(?)', [$userId]);
        
        //return $campusId;

        $participants = Participants::findOrFail($id);
     

        $trainingEnroller = DB::select('CALL fyl_get_training_user_enroller(?)',[$campusId]);

        return view('fyl/participants/edit', [
            'training' => $training,
            'campusId' => $campusId,
            'trainingId' => $trainingId,
            'participants' => $participants,
            'training_enroler' => $trainingEnroller,
            'gender' => Catalog::where('catalog_types_id', 1)->pluck('name', 'id'),
            'civil_status' => Catalog::where('catalog_types_id', 2)->pluck('name', 'id'),
          
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
                'birthdate' => ['nullable'],
                'gender_catalog_id' => ['nullable'],
                'civil_status_catalog_id' => ['nullable'],
                'city_of_residence' => ['nullable'],
                'address' => ['nullable'],
                'email' => ['required', 'string', 'email', 'max:255'],
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
            'city_of_residenceT' => $request->input('city_of_residence'),
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
        
        DB::select('CALL update_fyl_participants(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', 
            [
                $id,
                $request->input('DNI'),
                $request->input('names'),
                $request->input('surnames'),
                $request->input('nickname'),
                $request->input('birthdate'),
                $request->input('gender_catalog_id'),
                $request->input('civil_status_catalog_id'),
                $request->input('city_of_residence'),
                $request->input('address'),
                $request->input('email'),
                $request->input('phone'),
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
                $request->input('status'),
                auth()->id()
            ]);
        
        $training_id =  $request->input('training_id_enroller');
        
        $campus_id = DB::table('fyl_training')->select('campus_id')->where('id',$training_id)->first();

        
        return to_route('Participants.index', ['campus_id' => $campus_id->campus_id,'training_id' => $training_id])->with('status', 'Participant updated!');

    }

    public function destroy($id)
    {
        try {
            $participants = Participants::findOrFail($id);
            $participants->delete();
        } catch (Exception $e) {
            return to_route('Participants.index')->with('errors', 'El Participante no puede ser eliminado.' . $e->getMessage());
        }

        return to_route('Participants.index')->with('status', __('Participant deleted!'));
    }

    public function payment($id, $campus, $program, $trainingId, $trainingIdEnroller)
    {
        try {
            $participant = DB::select('CALL fyl_get_participant_payment(?)', [$id]);

            $participants = collect($participant)->first();
            
            $valida = 0;
            
            if($campus == 1)
            {
                if($this->validarCedulaEcuatoriana($participants->DNI))
                    $valida = 1;
            }
            
            $programId = Programs::where('name', $program)->first();

            $payment_participant = DB::table('fyl_payment_participant as PP')
                ->join('global_catalogs as P', 'P.id', '=', 'PP.price_type')
                ->select(
                    'PP.price_type',
                    'PP.price',
                    'P.name as priceType',
                    DB::raw("CONCAT(PP.price,'|',PP.program) as precio"),
                )
                ->where('participant_DNI', $participants->DNI)
                ->where('program', 'LIKE', '%' . $program[0] . '%')
                ->first();

            $record_payment = DB::select('CALL get_fyl_payment_participant(?,?)', [$participants->DNI,$program]);
            
            //return $record_payment;

            $totalAmount = 0;

            foreach ($record_payment as $payment) {
                $totalAmount += $payment->amount;
            }

            $balance = 0;

            if ($payment_participant !== NULL && $totalAmount>0){
                $balance = $payment_participant->price - $totalAmount;
            }


            $price = Prices::from('fyl_prices as P')
                ->join('global_catalogs as C', 'C.id', '=', 'P.catalogo_id_price_type')
                ->where('campus_id', $campus)
                ->where('program_id', $programId->id)
                ->orderBy('C.name', 'desc')
                ->pluck('C.name', 'C.id');

            $bank = Catalog::where('catalog_types_id', 8)->where('acronym','EC')->orderBy('name', 'asc')->pluck('name', 'id');
            
            if($campus == 2){
                $bank = Catalog::where('catalog_types_id', 8)->where('acronym','CO')->orderBy('name', 'asc')->pluck('name', 'id');
            }
            
            $data = [
                'payment' => new Payment,
                'payment_participant' => $payment_participant,
                'recordPayment' => $record_payment,
                'participants' => $participants,
                'campus_id' => $campus,
                'training_id' => $trainingId,
                'training_id_enroller' => $trainingIdEnroller,
                'program' => $programId,
                'payment_record' => Catalog::where('catalog_types_id', 10)->where('status','ACTIVE')->pluck('name', 'id'),
                'price_type' => $price,
                'price' => new Prices,
                'payment_method' => Catalog::where('catalog_types_id', 4)->where('status','ACTIVE')->pluck('name', 'id'),
                'card' => Catalog::where('catalog_types_id', 5)->pluck('name', 'id'),
                'tipoPago' => Catalog::where('catalog_types_id', 6)->orderByRaw('CAST(acronym AS SIGNED)')->pluck('name', 'id'),
                'bank' => $bank,
                'balance' => $balance,
                'campus' => $campus,
                'valida' => $valida,
                //'trainingIdSearch' => $trainingIdSearch
            ];

//return $data;

            return view('fyl/participants/payment', $data );
        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }

    public function payment_register(Request $request)
    {
        //return $request;
        try {
            $validatedData = Validator::make(
                $request->all(),
                [
                    'training_id' => ['required'],
                    'program_id' => ['required'],
                    'participant_DNI' => ['required'],
                    'payment_date' => ['required'],
                    'price_type' => ['required'],
                    'catalog_id_payment_method' => ['required'],
                    'prices_id' => ['required'],
                    'catalog_id_card' => ['nullable'],
                    'catalog_id_tipo_pago' => ['nullable'],
                    'catalog_id_bank' => ['nullable'],
                    'authorization_number' => ['nullable'],
                    'catalog_id_payment_record' => ['required'],
                    'amount' => ['required', 'numeric', 'gt:0'],
                    'consumidorFinal' => ['required'],
                    'CC_RUC' => ['nullable'],
                    'names_razon_social' => ['nullable'],
                    'email' => ['nullable'],
                    'address' => ['nullable'],
                    'phone' => ['nullable'],
                    'comment' => ['nullable'],
                ],
                $customMessages = [
                    'training_id.required' => 'Entrenamiento requerido',
                    'program_id.required' => 'Programa requerido',
                    'participant_DNI.' => 'Identificación requerida',
                    'payment_date.required' => 'Fecha requerida',
                    'price_type.required' => 'Tipo de precio requerido',
                    'catalog_id_payment_method.required' => 'Método requerido',
                    'prices_id.required' => 'Precio requerido',
                    'prices_id.numeric' => 'Precio debe ser numérico',
                    'catalog_id_payment_record.required' => 'Nombre de equipo requerido',
                    'amount.required' => 'Monto requerido',
                    'amount.numeric' => 'El monto debe ser numérico',
                    'amount.gt' => 'El monto debe ser mayor que cero',
                ]
            );

            $pago = $request->input('catalog_id_payment_record');

             if ($pago === '51') {
                if ($request->input('catalog_id_payment_method') != 100) {
                    $validatedData->after(function ($validator) use ($request) {
                        $parts = explode('|', $request->input('prices_id'));
                        $priceValor = (float)$parts[0];
                        $programs_included = $parts[1];
                        if ($priceValor != $request->input('amount') && $priceValor != 0) {
                            $validator->errors()->add('prices_id', 'Los campos Prices ID y Amount deben ser iguales.');
                        }
                    });

                    if ($validatedData->fails()) {
                        return back()->withErrors($validatedData)->withInput();
                    }
                }
            } else {
                if ($request->input('catalog_id_payment_method') != 100) {
                    $validatedData->after(function ($validator) use ($request) {
                        $parts = explode('|', $request->input('prices_id'));
                        $priceValor = (float)$parts[0];
                        if ($priceValor < $request->input('amount') && $priceValor != 0) {
                            $validator->errors()->add('amount', 'El monto no puede ser mayor que el precio');
                        }
                    });

                    if ($validatedData->fails()) {
                        return back()->withErrors($validatedData)->withInput();
                    }
                }
            }

            $parts = explode('|', $request->input('prices_id'));
            $priceValor = (float)$parts[0];
            $programs_included = $parts[1];

            $CC_RUC = $request->input('CC_RUC');


            if ($request->input('consumidorFinal') == "true") {
                $CC_RUC = "Consumidor final";
            }

            $estado = null;
            $mensaje = null;

            // Llamar al procedimiento almacenado
            $results = DB::select(
                'CALL fyl_insert_payments(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, @estado, @mensaje)',
                [
                    $request->input('training_id'),
                    $request->input('participant_DNI'),
                    $priceValor,
                    $programs_included,
                    $request->input('payment_date'),
                    $request->input('price_type'),
                    $request->input('catalog_id_payment_method'),
                    $request->input('catalog_id_card'),
                    $request->input('catalog_id_tipo_pago'),
                    $request->input('catalog_id_bank'),
                    $request->input('authorization_number'),
                    $request->input('catalog_id_payment_record'),
                    $request->input('amount'),
                    $CC_RUC,
                    $request->input('comment'),
                    auth()->id()
                ]
            );

            // Después de ejecutar el procedimiento almacenado, obtén los valores de salida
            $logEntry = DB::select('SELECT @estado AS estado, @mensaje AS mensaje')[0];
            $estado = $logEntry->estado;
            $mensaje = $logEntry->mensaje;

            $tablaClient = [
                'CC_RUC' => $request->input('CC_RUC'),
                'RUC' => $request->input('RUC'),
                'names_razon_social' => $request->input('names_razon_social'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'user_id' => auth()->id()
            ];

            if ($request->input('consumidorFinal') == "false") {
                
                $clients = Clients::where('CC_RUC', $request->input('CC_RUC'))->count();

                if ($clients !== 0) {
                    $clients = Clients::where('CC_RUC', $request->input('CC_RUC'))->first();
                    $clients->update($tablaClient);
                } else {
                    Clients::create($tablaClient);
                }
            }
            
            $training_id =  $request->input('trainingId');
        
            $campus_id = $request->input('campusId');

        
            return to_route('Participants.index', ['campus_id' => $campus_id,'training_id' => $training_id])->with('status', $mensaje);
            
            //return redirect()->route('Participants.index')->with('status', $mensaje);
            
        } catch (Exception $e) {

            $errorMessage = $e->getMessage(); // Esto te dará el mensaje de error completo
            $startPosition = strpos($errorMessage, 'La sumatoria de abonos');

            if ($startPosition !== false) {
                $errorMessage = substr($errorMessage, $startPosition); // Obtiene la parte del mensaje que comienza desde "La sumatoria de abonos"
                $errorMessage = strstr($errorMessage, '(Connection:', true); // Elimina la parte después de '(Connection:'
            }

            //echo $errorMessage;

            return back()->withErrors($errorMessage)->withInput();
            //return redirect()->back()->with('errors', $e->getMessage());
        }

    }

    public function payment_edit($id, $campus, $program, $trainingId, $trainingIdEnroller, $payment_id)
    {
        try {
            
            $payment = DB::table('fyl_payment')
                ->join('fyl_clients', 'fyl_payment.CC_RUC', '=', 'fyl_clients.CC_RUC')
                ->select('fyl_payment.id as payment_id', 'fyl_clients.*')
                ->where('fyl_payment.id', $payment_id)
                ->first();
                
            $data = [
                'participant_id' => $id, 
                'campusId' => $campus, 
                'program' => $program, 
                'trainingId' => $trainingId, 
                'trainingIdEnroller' => $trainingIdEnroller,
                'payment' => $payment,
                ];
                
                //return $data;
        
            return view('fyl/participants/payment-edit', $data); 
            
        } catch (Exception $e) {
            return to_route('Participants.index')->with('errors', 'El Pago no puede ser eliminado.' . $e->getMessage());
        }  
    }

    public function payment_update(Request $request)
    {
        try {
            
            //return $request;
            
            $payment = Payment::findOrFail($request->input('payment_id'));
            
           
            
            $tablaClient = [
                'CC_RUC' => $request->input('CC_RUC'),
                'names_razon_social' => $request->input('nombre_comercial'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'user_id' => auth()->id()
            ];
            
            $clients = Clients::where('CC_RUC', $request->input('CC_RUC'))->count();

            if ($clients !== 0) {
                $clients = Clients::where('CC_RUC', $request->input('CC_RUC'))->first();
                $clients->update($tablaClient);
            } else {
                Clients::create($tablaClient);
            }
            
            $dataUpdate = [
                'CC_RUC' => $request->input('CC_RUC'),
            ];
        
            $payment->update($dataUpdate);
            
            return redirect()->back()->with('success', 'Informacion Actualizada');

            //return to_route('Participants.index')->with('errors', 'El Pago no puede ser eliminado.' . $e->getMessage());
            
        } catch (Exception $e) {
            return to_route('Payment.editar')->with('error', $e->getMessage());
        }    
    }

    public function destroyPayment($id)
    {
        try {
            $payment = Payment::findOrFail($id);

            $results = DB::select(
                'CALL fyl_delete_payments(?, ?, @estado, @mensaje)',
                [
                    $id,
                    auth()->id()
                ]
            );

            return back()->withInput();
            
        } catch (Exception $e) {
            return to_route('Participants.index')->with('errors', 'El Pago no puede ser eliminado.' . $e->getMessage());
        }
    }


    public function updatePriceFlash(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        session(['selected_option' => $selectedValue]);

        return response()->json(['message' => 'Sesión actualizada']);
    }

    public function updateDNIFlash(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        session(['selected_option' => $selectedValue]);

        return response()->json(['message' => 'Sesión actualizada']);
    }

    public function findDNITrainingId($id)
    {
        
        if($id == 12 || $id == 14)
        {
            return DB::table('th_employees')
                ->select('DNI', DB::raw("(CONCAT(surnames, ' ', names)) AS name"))
                ->where('training_id', $id)
                ->orderBy('surnames', 'ASC')
                ->orderBy('names', 'ASC')
                ->get();
        }
        else
        {
            $participants = DB::select('CALL fyl_get_training_team(?)', [$id]);
            
            return $participants;
            
        }
            
    }

    public function findCC_RUCClient($CC_RUC)
    {
        return Clients::where('CC_RUC', $CC_RUC)
            ->orderby('names_razon_social', 'ASC')
            ->get();
    }

    public function generateQRCode(Request $request)
    {
        $data = $request->get('data'); // Obtener los datos para el código QR

        // Codificar los datos en formato URL
        $encodedData = urlencode($data);

        // Construir la URL del servicio de Google Charts para generar el código QR
        $qrCodeUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$encodedData";

        // Devolver una vista con la imagen del código QR
        return view('qrcode', ['qrCodeUrl' => $qrCodeUrl]);
    }


    public function obtenerParticipantesPorLetra(Request $request, $letra)
    {
        // Aquí obtén los participantes que empiezan con la letra seleccionada
        $participantes = Participants::whereRaw('LOWER(surnames) LIKE ?', [strtolower($letra) . '%'])
            ->select(
                'DNI',
                DB::raw("CONCAT(surnames,' ',names)  as name")
            )
            ->where('graduate', 'SI')
            ->orderby('surnames', 'ASC')
            ->get();
        // ->pluck('name','DNI');
        //$participantes = Participants::where('surnames', 'LIKE', $letra.'%');

        return response()->json(['participantes' => $participantes]);
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
    
    public function search_participantOtraSede(Request $request)
    {
        $trainingId = $request->trainingId;
        $search_participant = $request->search_participant;
        
        $participants = DB::select('CALL get_fyl_participant_for_other_campus(?,?)', [$trainingId,$search_participant]);
        
        return $participants;
    }
    
    public function search_participantOtraSedeYour(Request $request)
    {
        $trainingId = $request->trainingId;
        $search_participant = $request->search_participant;
        
        $participants = DB::select('CALL get_fyl_participant_for_other_campus_your(?,?)', [$trainingId,$search_participant]);
        
        return $participants;
    }
    
    public function graduate(Request $request, $id)
    {
        $participants = Participants::findOrFail($id);
        
        //return $participants;
        
        $dataUpdate = [
            'graduate' => 'SI'
        ];
        
        $participants->update($dataUpdate);
    }
    
    public function print_voucher()
    {
        return view('fyl/participants/voucher');
    }
    
}
