<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveStaffRequest;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Programs;
use App\Models\Fyl\Participants;
use App\Models\Fyl\Staff;
use App\Models\Fyl\Training;
use App\Models\Users;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
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

        if (empty($requestData)) {
            return view('fyl/staffFocus.index', [
                'trainingId' => 0,
                'training' => $training,
            ]);
        }
        else {
            
            $training_id = $request->training_id;
            $staff = $this->getStaffFocus($request->training_id);
            
            $contador = 1;
            
            foreach ($staff as $staffItem) {
                $staffItem->secuencial = $contador;
                $contador++;
            }

            return view('fyl/staffFocus.index', [
                'trainingId' => $training_id,
                'staff' => $staff,
                'training' => $training,
            ]);
        }

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $type = $request->type;

        $trainingId = $request->training_id;

        if ($type == 'nuevo') {
            return $this->createParticipants($request);
        }

        $program_id = 2;

        $existsStaff = DB::table('fyl_staff_focus')
            ->where('participant_DNI', $request->input('participant_DNI'))
            ->where('training_id', $request->input('training_id'))->first();

        if ($existsStaff) {
            $training = $this->getTrainingNext();
            $staff = $this->getStaffFocus($request->training_id);

            $request->session()->put('staff', $staff);
            $request->session()->put('training', $training);

            $mensaje = 'El Staff se encuentra registrado.';

            return redirect()->route('Staff.index')->with('status', $mensaje);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'training_id' => ['required'],
                'role' => ['required'],
                'participant_DNI' => ['required'],
            ],
            $customMessages = [
                'training_id.required' => 'Entrenamiento requerido',
                'role.required' => 'Rol requerido',
                'participant_DNI.required' => 'Staff requerido.'
            ]
        );

        if ($validator && $validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newStaff = [
            'training_id' => $request->input('training_id'),
            'program_id' => $program_id,
            'role' => $request->input('role'),
            'participant_DNI' => $request->input('participant_DNI'),
        ];

        Staff::create($newStaff + ['user_id' => auth()->id()]);

        $training = $this->getTrainingNext();

        $staff = $this->getStaffFocus($request->training_id);
        
        $contador = 1;
            
        foreach ($staff as $staffItem) {
            $staffItem->secuencial = $contador;
            $contador++;
        }

        return view('fyl/staffFocus.index', [
            'trainingId' => $trainingId,
            'staff' => $staff,
            'training' => $training,
        ]);
    }

    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next(?)', [$userId]);

        $collection = collect($result);

        return $collection->pluck('name', 'id')->toArray();
    }

    function getStaffFocus($training_id) {

        return  DB::select('CALL fyl_get_staff(?)', [$training_id]);

    }

    function createParticipants($request)
    {
        $campus = Training::select('campus_id')->where('id', $request->input('training_id1'))->first();
        $campus_id = $campus->campus_id;
        
        $training_id_original = 56;
        
        switch($campus_id) {
            case 2:
                $training_id_original = 55;
                break;
            case 3:
                $training_id_original = 54;
                break;
            default:
                // Puedes definir un valor predeterminado o manejar otros casos si es necesario
                $training_id_original = 56;
                break;
        }
        
            
            
        
        $validatedData = Validator::make(
            $request->all(),
            [
                'DNI' => [
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


        $DNI = $request->input('DNI');

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
                'training_id_original' => $training_id_original,
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
        
        $data = [
            'type'=>'normal',
            'training_id'=>$request->input('training_id1'),
            'role'=>$request->input('role'),
            'participant_DNI'=>$request->input('DNI'),
            ];
        
        return to_route('Staff.store', $data);
        
    }

    public function show(Campus $staff)
    {
    }

    public function edit(Campus $staff)
    {
    }
    
    public function updateStatement(Request $request )
    {
       $staff = DB::table('fyl_staff_focus')
                 ->where('training_id', $request->training_id)
                 ->where('participant_DNI', $request->staff_DNI)
                 ->first();
                 
        if ($staff) {
            $statement = intval($request->statement) ?: 0;
                         
            $staff->statement = $statement;
            
            DB::table('fyl_staff_focus')
                ->where('training_id', $request->training_id)
                ->where('participant_DNI', $request->staff_DNI)
                ->update(['statement' => $statement]);
        }
    }


    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'city_id' => ['required'],
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'status' => ['required'],
        ]);

        //return $validator;

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);

        $staff->update($data);

        return to_route('staff.index', $staff)->with('status', 'Staff updated!');
    }

    public function destroy($id)
    {
        try {
            $staff = Staff::findOrFail($id);

            $trainingId = $staff->training_id;

            $staff->delete();

            $training = $this->getTrainingNext();

            $staff = $this->getStaffFocus($trainingId);
            
            $contador = 1;
            
            foreach ($staff as $staffItem) {
                $staffItem->secuencial = $contador;
                $contador++;
            }

            return view('fyl/staffFocus.index', [
                'trainingId' => $trainingId,
                'staff' => $staff,
                'training' => $training,
            ]);

        } catch (Exception $e) {
            return to_route('Staff.index')->with('errors', 'El Staff no puede ser eliminado.');
        }
    }
}
