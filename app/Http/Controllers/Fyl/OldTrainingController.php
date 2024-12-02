<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveCampusRequest;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class OldTrainingController extends Controller
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

        $userId = auth()->id();

        $training = DB::table('fyl_training as T')
            ->where('T.number',0)
            ->where('T.team_name', 'LIKE', '%' . $search . '%')
            ->orderBy('T.team_name','asc')
            ->paginate($pag);

        return view('fyl/training.old_team',['training' => $training]);
    }


    public function create()
    {
        $userId = auth()->id();

        $campus = DB::select('CALL fyl_get_campus_user(?)', [$userId]);

        return view('fyl/training/create-old', [
            'training' => new Training,
            'campus' => $campus
        ]);
    }

    public function store(Request $request)
    {
        $campusId = $request->campus_id;
        $number = 0;
        $teamName = $request->team_name;
        $status = $request->status;
        $userId = auth()->id();

        $validator = Validator::make($request->all(), [
            'campus_id' => ['required'],
            'team_name' => ['required'],
            'status' => ['required']
        ]);
        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'campus_id' => $campusId,
            'number' => $number,
            'team_name' => $teamName,
            'status' => $status,
            'user_id' => $userId,
        ];

        Training::create($data);

        return to_route('OldTraining.index')->with('status','Team created!');

    }

    public function show(Campus $Campus)
    {

    }

    public function edit($id)
    {
        $userId = auth()->id();

        $campus = DB::select('CALL fyl_get_campus_user(?)', [$userId]);

        $training = Training::where('id', $id)->first();

        return view('fyl/training/edit-old', [
            'campus' => $campus,
            'training' => $training
        ]);

    }

    public function update(Request $request, $id)
    {
        $campusId = $request->campus_id;
        $number = 0;
        $teamName = $request->team_name;
        $status = $request->status;
        $userId = auth()->id();

        $Training = Training::findOrFail($id);


        $validator = Validator::make($request->all(), [
            'campus_id' => ['required'],
            'team_name' => ['required'],
            'status' => ['required']
        ]);
        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'campus_id' => $campusId,
            'number' => $number,
            'team_name' => $teamName,
            'status' => $status,
            'user_id' => $userId,
        ];

        $Training->update($data);

        return to_route('OldTraining.index')->with('status','Team updated!');
    }

    public function destroy(Campus $Campus)
    {

    }


}
