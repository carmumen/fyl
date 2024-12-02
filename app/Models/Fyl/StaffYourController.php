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
        $requestData = $request->all();

        $training = $this->getTrainingNext();

        if (empty($requestData)) {
            return view('fyl/staffYour.index', [
                'training' => $training,
            ]);
        }
        else {
            $staff = $this->getStaffYour($request->training_id);
            return view('fyl/staffYour.index', [
                'staff' => $staff,
                'training' => $training,
            ]);
        }


    }

    function getTrainingNext() {
        $userId = auth()->id();

        $result = DB::select('CALL fyl_get_training_next(?)', [$userId]);

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
        $training_id = $request->training_id;
        $userId = auth()->id();

        $existsStaff = DB::table('fyl_staff_focus')
            ->where('training_id', $request->input('training_id'))->first();

        if ($existsStaff) {

            DB::select('CALL insert_staff_your_massive(?,?)', [$training_id, $userId]);
            return to_route('StaffYour.index', $training_id)->with('status', 'Staff creado!');
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

        if ($type == 'nuevo') {
            return $this->createParticipants($request);
        }

        $existsStaff = DB::table('fyl_staff_your')
            ->where('participant_DNI', $request->input('participant_DNI'))
            ->where('training_id', $request->input('training_id'))->first();

        if ($existsStaff) {
            $training = $this->getTrainingNext();
            $staff = $this->getStaffYour($request->training_id);

            $request->session()->put('staff', $staff);
            $request->session()->put('training', $training);

            $mensaje = 'El Staff se encuentra registrado.';

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
            'staff' => $staff,
            'training' => $training,
        ]);
    }

    public function show(Campus $staff)
    {
        return view('fyl/campus/show', ['staff' => $staff]);
    }

    public function edit(Campus $staff)
    {

    }

    public function update(Request $request, $id)
    {
        $staff = StaffYour::findOrFail($id);

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

        return to_route('staff.index', $staff)->with('status', 'Campus updated!');
    }

    public function destroy($id)
    {
        try {
            $staff = StaffYour::findOrFail($id);
            $staff->delete();

            $training = DB::table('fyl_training as T')
                ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
                ->join(DB::raw('(select campus_id, min(start_date_focus) start_date_focus
                        from fyl_training T
                        where start_date_focus is not null
                        and start_date_focus > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                        group by campus_id) as F'), function ($join) {
                    $join->on('C.id', '=', 'F.campus_id')
                        ->whereColumn('T.start_date_focus', '=', 'F.start_date_focus');
                })
                ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
                ->pluck('name', 'id');

            $program = Programs::where('life_stage', 25)->pluck('name', 'id');


            $staff = StaffYour::from('fyl_staff as S')
                ->join('fyl_participants as P', 'S.participant_DNI', '=', 'P.DNI')
                ->join('fyl_programs as PR', 'S.program_id', '=', 'PR.id')
                ->select(
                    'S.id',
                    'S.training_id',
                    'S.program_id',
                    'S.role',
                    'S.participant_DNI',
                    'PR.name as program',
                    DB::raw("CONCAT(P.surnames,' ',P.names)  as staff"),
                    'P.email',
                    'P.phone'
                )
                ->where('S.training_id', $staff->training_id)
                ->where('S.program_id', $staff->program_id)
                ->orderBy('S.role', 'asc')
                ->orderBy('P.surnames', 'asc')
                ->get();

            foreach ($staff as $index => $staffItem) {
                $staffItem->secuencial = $index + 1;
            }



            return view('fyl/staffFocus.index', [
                'staff' => $staff,
                'training' => $training,
                'program' => $program,
            ]);


            return to_route('Staff.index')->with('status', __('Staff deleted!'));
        } catch (Exception $e) {
            return to_route('Staff.index')->with('errors', 'El Staff no puede ser eliminado.');
        }
    }
}
