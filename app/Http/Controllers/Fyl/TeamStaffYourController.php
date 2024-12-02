<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveCampusRequest;
use App\Models\Fyl\TrainingTeam;
use App\Models\Fyl\StaffYour;
use App\Models\Fyl\YourParticipants;
use App\Models\Fyl\Participants;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class TeamStaffYourController extends Controller
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

        $userId = auth()->id();

        $training = DB::table('fyl_next_training_your_view as T')
            ->join('fyl_campus as C', 'T.campus_id', '=', 'C.id')
            ->join('fyl_campus_user as CU', 'C.id', '=', 'CU.campus_id')
            ->select('T.id', DB::raw("CONCAT(C.name, ' FYL ', T.number) as name"))
            ->where('CU.user_id',$userId)
            ->pluck('name', 'id');



        if (empty($requestData)) {

            return view('fyl/yourParticipants.team', [
                'staffDNI' => 0,
                'training' => $training
            ]);
        }
        else
        {
            $trainingId = $request->training_id;

            $staffDNI = $request->staff_DNI;


            $staff = DB::table('fyl_staff_your_view')->where('training_id',$trainingId)->pluck('name','id');

            $staff_legendary = [];//DB::table('fyl_staff_Legendary_focus_view')->where('training_id',$trainingId)->pluck('name','id');

            $team_staff_legendary = [];// DB::table('fyl_team_legendary_staff_focus_view')->where('training_id',$trainingId)->get();

            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($team_staff_legendary as $team_staff_legendaryItem) {
                $team_staff_legendaryItem->secuencial = $contador;
                $contador++;
            };

            $participants = DB::table('fyl_your_participants_view')->where('training_id',$trainingId)->pluck('name','id');

            //return $participants;

            $staffDNI = $request->staff_DNI;

            $yourParticipants = DB::table('fyl_your_participants_staff_view as FP')
                ->where('FP.training_id', $trainingId)
                ->orderBy('participant', 'asc')
                ->get();

            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($yourParticipants as $yourParticipantsItem) {
                $yourParticipantsItem->secuencial = $contador;
                $contador++;
            };
            //return $legendary;

            return view('fyl/yourParticipants.team', [
                'staffDNI' => $staffDNI,
                'staff' => $staff,
                'participants'=> $participants,
                'trainingId' => $trainingId,
                'training' => $training,
                'yourParticipants' => $yourParticipants,
            ]);
        }
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        try {

            //return $request;

            $your = DB::table('fyl_your_participants')->where('id',$request->participants_DNI)->first();
            //return $your;

            if ($your) {
                DB::table('fyl_your_participants')
                    ->where('id', $request->participants_DNI)
                    ->update(['staff_DNI' => $request->staff_DNI]);
            }

            return to_route('TeamStaffYour.index',[
                'training_id'=>$request->training_id,
                'staff_DNI' => $request->staff_DNI
                ])->with('status','Life Template create!');


        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeTS(Request $request)
    {
        try {

            //return $request;

            $your = DB::table('fyl_staff_your')->where('id',$request->staff_legendary_DNI)->first();

            if ($your) {
                DB::table('fyl_staff_your')
                    ->where('id', $request->staff_legendary_DNI)
                    ->update(['legendary_DNI' => $request->legendary_DNI]);
            }

            return to_route('TeamStaff.index',[
                'training_id'=>$your->training_id,
                'legendary_DNI' => $request->legendary_DNI
                ])->with('status','Life Template create!');


        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Staff $Staff)
    {
    }

    public function edit(Staff $Staff)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $your = DB::table('fyl_your_participants')->where('id',$id)->first();
        if ($your) {
            DB::table('fyl_your_participants')
                ->where('id', $id)
                ->update(['staff_DNI' => null]);
        }
        return to_route('TeamStaffYour.index',[
            'training_id' => $your->training_id,
            'staff_DNI' => $your->staff_DNI,
            ])->with('status','!');
    }

    public function destroySL($id)
    {
        $your = DB::table('fyl_staff_your')->where('id',$id)->first();
        if ($your) {
            DB::table('fyl_staff_your')
                ->where('id', $id)
                ->update(['legendary_DNI' => null]);
        }
        return to_route('TeamStaff.index',[
            'training_id' => $your->training_id,
            'legendary_DNI' => $your->legendary_DNI,
            ])->with('status','!');
    }

}
