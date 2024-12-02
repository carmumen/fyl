<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Programs;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Staff;
use App\Models\Fyl\MasterLife;
use App\Models\Users;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Config;
use Exception;

class MasterLifeController extends Controller
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

        $training = $this->getTrainingNext();

        if (empty($requestData) || $request->training_id == 0) {
            return view('fyl/masterLife.index', [
                'trainingId' => 0,
                'training' => $training,
            ]);
        }
        else {
            $training_id = $request->training_id;
            $master = $this->getMasterLife($request->training_id);
            $exists = 'NO';
            if ($master)
                $exists = 'SI';

            return view('fyl/masterLife.index', [
                'trainingId' => $training_id,
                'masterLife' => $master,
                'training' => $training,
                'exists' => $exists,
            ]);
        }


    }

    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next_life(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }

    function getMasterLife($training_id) {

        return  DB::select('CALL fyl_get_master_life(?)', [$training_id]);

    }

    public function storeMassive(Request $request)
    {
        $trainingId = $request->training_id;
        $userId = auth()->id();

        $training = $this->getTrainingNext();

        $existsMaster = DB::table('fyl_staff_your')
            ->where('training_id', $trainingId)->first();



        if ($existsMaster) {

            DB::select('CALL insert_master_life_massive(?,?)', [$trainingId, $userId]);
            $master = $this->getMasterLife($trainingId);

            return to_route('MasterLife.index', [
                'trainingId' => $trainingId,
                'masterLife' => $master,
                'training' => $training,
            ]);
        }
        else {
            $training = $this->getTrainingNext();
            $request->session()->put('training', $training);
            $mensaje = 'No hay staff registrado en Focus para este entrenamiento.';

            return redirect()->back()->with('status', $mensaje);

            //return redirect()->route('StaffYour.index')->with('status', $mensaje);
        }

    }

    public function store(Request $request)
    {
        $type = $request->type;

        $trainingId = $request->training_id;

        if ($type == 'nuevo') {
            $this->createParticipants($request);
        }

        $existsMaster = DB::table('fyl_master_life')
            ->where('participant_DNI', $request->input('participant_DNI'))
            ->where('training_id', $request->input('training_id'))->first();

        if ($existsMaster) {
            $training = $this->getTrainingNext();
            $masterLife = $this->getMasterLife($request->training_id);

            $request->session()->put('masterLife', $masterLife);
            $request->session()->put('training_ml', $training);
            $request->session()->put('trainingId_ml', $trainingId);
            $request->session()->put('exist_ml', 'SI');

            $mensaje = 'Master Life registrado.';

            return redirect()->route('MasterLife.index')->with('status', $mensaje);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'training_id' => ['required'],
                'participant_DNI' => ['required'],
            ],
            $customMessages = [
                'training_id.required' => 'Entrenamiento requerido',
                'participant_DNI.required' => 'Staff requerido.'
            ]
        );

        if ($validator && $validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newStaff = [
            'training_id' => $request->input('training_id'),
            'role' => 'MASTER LIFE',
            'participant_DNI' => $request->input('participant_DNI'),
        ];

        MasterLife::create($newStaff + ['user_id' => auth()->id()]);

        $training = $this->getTrainingNext();

        $master = $this->getMasterLife($request->training_id);

        return view('fyl/masterLife.index', [
            'trainingId' => $trainingId,
            'masterLife' => $master,
            'training' => $training,
        ]);
    }

    function createParticipants($request)
    {
        $validatedData = Validator::make(
            $request->all(),
            [
                'participant_DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                ],
                'names' => ['required'],
                'surnames' => ['required'],
                'nickname' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
            ]
        );



        if ($validatedData && $validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $DNI = $request->input('participant_DNI');

        $participant = Participants::where('DNI', $DNI)->first();

        $hash = hash('sha256', $DNI);
        $hash = substr($hash, 0, 60);

        $mensaje = 'Master Life creado. Proceda a seleccionarlo para incluirlo.';

        if ($participant) {
            $participant->update([
                'names' => $request->input('names'),
                'surnames' => $request->input('surnames'),
                'nickname' => $request->input('nickname'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'hash' => $hash,
                'graduate' => 'SI',
            ]);
            $mensaje = 'Master Life actualizado. Proceda a seleccionarlo para incluirlo.';
        } else {
            $dataCreate = [
                'DNI' => $DNI,
                'names' => $request->input('names'),
                'surnames' => $request->input('surnames'),
                'nickname' => $request->input('nickname'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'status' => 'ACTIVE',
                'training_id' => 999999999,
                'hash' => $hash,
                'graduate' => 'SI',
                'user_id' => auth()->id()
            ];

            Participants::create($dataCreate);
        }

    }

    public function create()
    {
    }

    public function show(Campus $staff)
    {
    }

    public function edit(Campus $staff)
    {
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        try {
            $master = MasterLife::findOrFail($id);
            //return $master;

            $trainingId = $master->training_id;
            //return $trainingId;

            $master->delete();

            $training = $this->getTrainingNext();

            $master = $this->getMasterLife($trainingId);

            $exists = 'NO';
            if ($master)
                $exists = 'SI';


            return view('fyl/masterLife.index', [
                'trainingId' => $trainingId,
                'masterLife' => $master,
                'training' => $training,
                'exists' => $exists,
            ]);

        } catch (Exception $e) {
            return to_route('fyl/masterLife.index')->with('errors', 'El Staff no puede ser eliminado.');
        }
    }
}
