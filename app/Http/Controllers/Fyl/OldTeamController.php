<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Fyl\Participants;
use App\Models\TH\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Exception;

class OldTeamController extends Controller
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
        
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 30;

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id();

        $participant = DB::table('fyl_participants_old_view')
            ->where(function ($query) use ($search) {
                $query->where('names', 'LIKE', '%' . $search . '%')
                    ->orWhere('surnames', 'LIKE', '%' . $search . '%')
                    ->orWhere('DNI', '=', $search);
            })
            ->paginate($pag);

        return view('fyl/training.old_member',['participant' => $participant]);
    }


    public function create()
    {
        $userId = auth()->id();

        $training = DB::table('fyl_training_old_view')->get();

        return view('fyl/training/create-team', [
            'participants' => new Participants(),
            'training' => $training
        ]);
    } 
    
    public function store(Request $request)
    {
        $dni = $request->DNI;
        $graduate = 'SI';
        $names = $request->names;
        $surnames = $request->surnames;
        $nickname = $request->nickname;
        $phone = $request->phone;
        $email = $request->email;
        $training_id = $request->training_id;
        $status = $request->status;
        $userId = auth()->id();

        $validator = Validator::make($request->all(), [
            'DNI' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('fyl_participants')->ignore($request->input('DNI')),
            ],
            'names' => ['required'],
            'surnames' => ['required'],
            'nickname' => ['required'],
            'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
            'email' => [
                'required',
                'email',
                Rule::unique('fyl_participants')->ignore($request->input('email')),
            ],
            'training_id' => ['required'],
            'status' => ['required']
        ]);
        if ($validator && $validator->fails()) {
            // Si la validaci¨®n falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);

        $data = [
            'DNI' => $dni,
            'names' => $names,
            'surnames' => $surnames,
            'nickname' => $nickname,
            'phone' => $phone,
            'email' => $email,
            'training_id' => $training_id,
            'hash' => $hash,
            'status' => $status,
            'user_id' => $userId,
        ];

        $number = DB::table('fyl_training')->where('id',$training_id)->first();


        if($number->number == 0){
            Participants::create($data + ['graduate' => $graduate]);
        }

        if($number->number == 888888888){
            Employee::create($data);
        }

        if($number->number == 999999999){
            Employee::create($data + ['department_id' => 8]);
        }

        return to_route('OldTeam.index')->with('status','Member created!');

    }

    public function show(Participants $Participants)
    {

    }

    public function edit($id)
    {
        $parts = explode('|', $id);
        $training_number = $parts[0];
        $DNI = $parts[1];

        $training = DB::table('fyl_training_old_view')->get();

        $participants = DB::table('fyl_participants_old_view')
                ->where('number',$training_number)
                ->where('DNI',$DNI)->first();

        return view('fyl/training/edit-team', [
            'training' => $training,
            'participants' => $participants
        ]);

    }

    public function update(Request $request, $id)
    {
        $parts = explode('|', $id);
        $training_number = $parts[0];
        $DNI_old = $parts[1];

        $dni = $request->DNI;
        $graduate = 'SI';
        $names = $request->names;
        $surnames = $request->surnames;
        $nickname = $request->nickname;
        $phone = $request->phone;
        $email = $request->email;
        $training_id = $request->training_id;
        $status = $request->status;
        $userId = auth()->id();

        $validator = Validator::make($request->all(), [
            'DNI' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('fyl_participants')->ignore($request->input('DNI'), 'DNI'),
            ],
            'names' => ['required'],
            'surnames' => ['required'],
            'nickname' => ['required'],
            'phone' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('fyl_participants')->ignore($request->input('email'),'email'),
            ],
            'training_id' => ['required'],
            'status' => ['required']
        ]);
        if ($validator && $validator->fails()) {
            // Si la validaci¨®n falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $hash = hash('sha256', $request->input('DNI')); // Calcula el hash SHA-256
        $hash = substr($hash, 0, 60);


        $data = [
            'DNI' => $dni,
            'names' => $names,
            'surnames' => $surnames,
            'nickname' => $nickname,
            'phone' => $phone,
            'email' => $email,
            'training_id' => $training_id,
            'hash' => $hash,
            'status' => $status,
            'user_id' => $userId,
        ];

        $Participants = [];

        if($training_number == 0){
            $Participants = Participants::where('DNI',$DNI_old);
            $Participants->update($data + ['graduate' => $graduate]);
        }

        if($training_number == 888888888){
            $Participants = Employee::where('DNI',$DNI_old);
            $Participants->update($data);
        }

        if($training_number == 999999999){
            $Participants = Employee::where('DNI',$DNI_old);
            $Participants->update($data + ['department_id' => 8]);
        }

        return to_route('OldTeam.index')->with('status','Member updated!');
    }

    public function destroy(Participants $Participants)
    {

    }

}
