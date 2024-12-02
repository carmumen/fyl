<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveProgramsRequest;
use App\Models\Global\Catalog;
use App\Models\Fyl\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class ProgramsController extends Controller
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

        $program = Programs::from('fyl_programs as P')
                        ->join('global_catalogs AS C', 'C.id', '=', 'P.life_stage')
                        ->select('P.id',
                                 'P.name',
                                 'P.level',
                                 'P.status',
                                 'C.name AS life_stage')
                        ->where('P.name', 'LIKE', '%' . $search . '%')
                        ->orderBy('P.life_stage','asc')
                        ->orderBy('P.level','asc')
                        ->paginate($pag);

        $program->appends(['search' => $search, 'pag' => $pag]);

        return view('fyl/programs.index',['program' => $program, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('fyl/Programs/create', [
            'life_stages' => Catalog::where('catalog_types_id',7)->pluck('name','id'),
            'programs' => new Programs]);
    }

    public function store(SaveProgramsRequest $request)
    {
        Programs::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Programs.index')->with('status','Programs create!');
    }

    public function show(Programs $program)
    {
        return view('fyl/programs/show',['Programs' => $program]);
    }

    public function edit($id)
    {
        $program = Programs::findOrFail($id);

        // return [
        //     'life_stage' => Catalog::where('catalog_types_id',7)->pluck('name','id'),
        //     'programs' => $program];

        return view('fyl/programs/edit', [
            'life_stages' => Catalog::where('catalog_types_id',7)->pluck('name','id'),
            'programs' => $program]);
    }

    public function update(Request $request, $id)
    {
        $program = Programs::findOrFail($id);

        $program->user_id = auth()->id();

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'life_stage' => ['required'],
            'level' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);

        $program->update($data);

        return to_route('Programs.index', $program)->with('status','Program updated!');
    }

    public function destroy($id)
    {
        try {
            $program = Programs::findOrFail($id);
            $program->delete();

        } catch (Exception $e) {
            return to_route('Programs.index')->with('errors','El Programa no puede ser eliminado.');
        }

        return to_route('Programs.index')->with('status',__('Program deleted!'));
    }


}
