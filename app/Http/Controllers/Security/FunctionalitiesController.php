<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Security\SaveFunctionalityRequest;
use App\Models\Aplication;
use App\Models\Module;
use App\Models\Functionality;
use Illuminate\Http\Request;
use Exception;

class FunctionalitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 200;

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);

        $functionalities = Functionality::from('security_functionalities AS F')
            ->join('security_aplications as A', 'A.id', '=', 'F.aplication_id')
            ->join('security_modules as M', 'M.id', '=', 'F.module_id')
            ->leftjoin('security_modules AS parent', 'parent.id', '=', 'M.parent')
            ->where('A.name', 'LIKE', '%' . $search . '%')
            ->orwhere('F.name', 'LIKE', '%' . $search . '%')
            ->orwhere('F.route', 'LIKE', '%' . $search . '%')
            ->select(
                'F.id',
                'A.name as aplication',
                'F.name',
                'F.order',
                'F.route',
                'F.state',
                DB::raw("(CASE WHEN M.parent = 0 THEN M.name ELSE (CONCAT(parent.name,' - ',M.name)) END) as modules")
            )
           // ->groupby('F.id', 'A.name', 'M.name', 'F.name', 'F.route', 'M.state', 'modules')
            ->orderBy('A.name', 'asc')
            ->orderBy('parent.name', 'asc')
            ->orderBy('M.order', 'asc')
            ->orderBy('F.order', 'asc')
            ->paginate($pag);

        $contador = ($functionalities->currentPage() - 1) * $functionalities->perPage() + 1;

        // Asignar el número secuencial a cada registro
        foreach ($functionalities as $functionalitiesItem) {
            $functionalitiesItem->secuencial = $contador;
            $contador++;
        }

        $functionalities->appends(['search' => $search, 'pag' => $pag]);

        return view('security/functionalities/index', ['functionality' => $functionalities, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('security/functionalities/create', [
            'module' => [],
            'parent_module' => [],
            'functionality' => new Functionality,
            'aplication' => Aplication::orderBy('name', 'ASC')->pluck('name', 'id')
        ]);
    }

    public function store(SaveFunctionalityRequest $request)
    {
        Functionality::create($request->validated());

        return to_route('Functionalities.index')->with('status', 'Functionality create!');
    }

    public function show(Functionality $Functionality)
    {
        return view('security/functionalities/show', ['Functionality' => $Functionality]);
    }

    public function edit(Functionality $Functionality)
    {
        return view('security/functionalities/edit', [
            'functionality' => $Functionality,
            'module' => Module::from('security_modules AS M')
                ->rightjoin('security_modules AS parent', 'parent.parent', '=', 'M.id')
                ->select("parent.id", DB::raw("(CASE WHEN parent.parent = 0 THEN parent.name ELSE (CONCAT(M.name,' - ',parent.name)) END) as name"))
                ->pluck('name', 'id'),
            'aplication' => Aplication::orderBy('name', 'ASC')->pluck('name', 'id')
        ]);
    }

    public function update(SaveFunctionalityRequest $request, Functionality $Functionality)
    {
        $Functionality->update($request->validated());

        return to_route('Functionalities.index', $Functionality)->with('status', 'Functionality updated!');
    }

    public function destroy(Functionality $Functionality)
    {
        try {
            $Functionality->delete();
        } catch (Exception $e) {
            return to_route('Functionalities.index')->with('errors', 'La funcionalidad no puede ser eliminada.');
        }
        return to_route('Functionalities.index')->with('status', 'Functionality deleted!');
    }

    public function findFunctionalityByAplicationId($id)
    {
        return DB::table('security_functionalities as f')
        ->join('security_modules as m', 'f.module_id', '=', 'm.id')
        ->where('f.aplication_id', $id)
        ->select('f.id', DB::raw("CONCAT(m.name, ' - ', f.name) as name"))
        ->orderBy('m.name')
        ->orderBy('f.name')
        ->get();
    }
}
