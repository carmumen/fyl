<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveFdsRequest;
use App\Models\Fyl\Fds;
use App\Models\Fyl\FdsTeam;
use App\Models\Fyl\Training;
use App\Models\Fyl\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class EgressIncomeController extends Controller
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

        $search = $request->input('search');
        $pag = $request->input('pag') ?: 30;
        
        $userId = auth()->id();

        $fds = Fds::from('fyl_fds as F')
            ->join('fyl_campus as C', 'F.campus_id', '=', 'C.id')
            ->join('fyl_campus_user as CU', 'C.id', 'CU.campus_id')
            ->join('fyl_training as T', 'F.training_in_game', '=', 'T.id')
            ->select(
                'F.id',
                'C.name',
                DB::raw("CONCAT('FYL - ', T.number) as training_in_game"),
                'F.start_date',
                'F.end_date'
            )
            ->where('CU.user_id', $userId)
            ->where('C.name', 'LIKE', '%' . $search . '%')
            ->orderBy('F.training_in_game', 'desc')
            ->paginate($pag);


        $fds->appends(['search' => $search, 'pag' => $pag]);

        $contador = ($fds->currentPage() - 1) * $fds->perPage() + 1;

        // Asignar el número secuencial a cada registro
        foreach ($fds as $fdsItem) {
            $fdsItem->secuencial = $contador;
            $contador++;
        }

        if (empty($requestData)) {
            return view('fyl/egressIncome.index', [
                'fds' => $fds,
                'search' => $search,
                'pag' => $pag,
                'campusId' => 0
            ]);
        } else {
            return view('fyl/egressIncome.index', [
                'fds' => $fds,
                'search' => $search,
                'pag' => $pag,
                'campusId' => $request->campus_id
            ]);
        }
    }


    public function create()
    {
        $userId = auth()->id();

        $campus = DB::table('fyl_campus as c')
            ->join('fyl_campus_user as cu', 'c.id', 'cu.campus_id')
            ->where('cu.user_id', $userId)
            ->select('c.id', 'c.name')
            ->pluck('name', 'id');

        return view('fyl/fds/create', [
            'campus' => $campus,
            'campusId' => 0,
            'fds' => new Fds
        ]);
    }


    public function store(SaveFdsRequest $request)
    {
        Fds::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Fds.index')->with('status', 'Fds create!');
    }


    public function show(Fds $fds)
    {
    }

    public function edit($id)
    {
        $userId = auth()->id();

        $campus = DB::table('fyl_campus as c')
            ->join('fyl_campus_user as cu', 'c.id', 'cu.campus_id')
            ->where('cu.user_id', $userId)
            ->select('c.id', 'c.name')
            ->pluck('name', 'id');

        $fds = Fds::findOrFail($id);

        return view('fyl/fds/edit', [
            'campus' => $campus,
            'campusId' => $fds->campus_id,
            'fds' => $fds
        ]);
    }


    public function update(SaveFdsRequest $request, $id)
    {
        $fds = Fds::findOrFail($id);

        $fds->update($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Fds.index', $fds)->with('status', 'FDS updated!');
    }
    

    public function destroy($id)
    {
        try {
            $fds = Fds::findOrFail($id);
            $fds->delete();
            return to_route('Fds.index')->with('status', __('Fds deleted!'));
        } catch (Exception $e) {
            return to_route('Fds.index')->with('errors', 'El FDS no puede ser eliminado.');
        }
    }

}
