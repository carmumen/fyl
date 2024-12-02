<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveStaffRequest;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Programs;
use App\Models\Fyl\Participants;
use App\Models\Fyl\StaffYour;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class StaffYourController extends Controller
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
            return view('fyl/staffYour.index', [
                'trainingId' => 0,
                'training' => $training,
            ]);
        }
        else {
            $training_id = $request->training_id;
            $staff = $this->getStaffYour($training_id);
            $exists = 'NO';
            if ($staff)
                $exists = 'SI';

            return view('fyl/staffYour.index', [
                'trainingId' => $training_id,
                'staff' => $staff,
                'training' => $training,
                'exists' => $exists,
            ]);
        }


    }

    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next_your(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }

    function getStaffYour($training_id) {

        return  DB::select('CALL fyl_get_staff_your(?)', [$training_id]);

    }

    public function create()
    {
    }

    public function storeMassive(Request $request)
    {
        //return $request;
        $trainingId = $request->training_id;
        $userId = auth()->id();

        $training = $this->getTrainingNext();

        $existsStaff = DB::table('fyl_staff_focus')
            ->where('training_id', $trainingId)->first();

        if ($existsStaff) {

            DB::select('CALL insert_staff_your_massive(?,?)', [$trainingId, $userId]);
            $staff = $this->getStaffYour($trainingId);

            return view('fyl/staffYour.index', [
                'trainingId' => $trainingId,
                'staff' => $staff,
                'training' => $training,
                'exists' => 'SI',
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
        //return $request;
        $type = $request->type;

        $trainingId = $request->training_id;

        if ($type == 'nuevo') {
            $this->createParticipants($request);
        }

        $existsStaff = DB::table('fyl_staff_your')
            ->where('participant_DNI', $request->input('participant_DNI'))
            ->where('training_id', $request->input('training_id'))->first();

        if ($existsStaff) {
            $training = $this->getTrainingNext();
            $staff = $this->getStaffYour($request->training_id);

            $request->session()->put('staff', $staff);
            $request->session()->put('training', $training);
            $request->session()->put('trainingId_y', $trainingId);
            $request->session()->put('exist_y', 'SI');

            $mensaje = 'Staff registrado.';

            return redirect()->route('StaffYour.index')->with('status', $mensaje);
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
            'role' => 'STAFF',
            'participant_DNI' => $request->input('participant_DNI'),
        ];

        StaffYour::create($newStaff + ['user_id' => auth()->id()]);

        $training = $this->getTrainingNext();

        $staff = $this->getStaffYour($request->training_id);

        return view('fyl/staffYour.index', [
            'trainingId' => $trainingId,
            'staff' => $staff,
            'training' => $training,
            'exists' => 'SI',
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

        $mensaje = 'Staff creado. Proceda a seleccionarlo para incluirlo.';

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
            $mensaje = 'Staff actualizado. Proceda a seleccionarlo para incluirlo.';
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
            $staff = StaffYour::findOrFail($id);

            $trainingId = $staff->training_id;

            $staff->delete();

            $training = $this->getTrainingNext();

            $staff = $this->getStaffYour($trainingId);

            $exists = 'NO';
            if ($staff)
                $exists = 'SI';

            return view('fyl/staffYour.index', [
                'trainingId' => $trainingId,
                'staff' => $staff,
                'training' => $training,
                'exists' => $exists,
            ]);

        } catch (Exception $e) {
            return to_route('fyl/staffYour.index')->with('errors', 'El Staff no puede ser eliminado.');
        }
    }
}
