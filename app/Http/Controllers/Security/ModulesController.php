<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Security\SaveModuleRequest;
use App\Models\Aplication;
use App\Models\Module;
use App\Models\Functionality;
use Illuminate\Http\Request;
use Exception;

class ModulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $module = Module::from('security_modules AS M')
                        ->join('security_aplications as A', 'A.id', '=', 'M.aplication_id')
                        ->leftjoin('security_modules as PM', 'M.parent', '=', 'PM.id')
                        ->where('A.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('M.name', 'LIKE', '%' . $search . '%')
                        ->select('M.id',
                                 'M.aplication_id',
                                 'A.name as aplication',
                                 'M.parent',
                                  DB::raw('(CASE WHEN M.parent = 0 THEN "_PARENT_" ELSE PM.name END) AS parent_module'),
                                 'M.name',
                                 'M.order',
                                 'M.state')
                        ->orderBy('M.aplication_id','ASC')
                        ->orderBy('parent_module','ASC')
                        ->orderBy('M.order','ASC')
                        ->paginate($pag);

         $module->appends(['search' => $search, 'pag' => $pag]);

        return view('security/modules/index',['module' => $module, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('security/modules/create', [
            'module' => new Module,
            'parent_module' => [],
            'aplication' => Aplication::orderBy('name','ASC')->pluck('name','id')
        ]);
    }


    public function store(SaveModuleRequest $request)
    {
        Module::create($request->validated());

        if ($request->parent = 0){
            DB::table('security_modules')
            ->where('id', 0)
            ->update(['parent' => 'id']);
        }

        return to_route('Modules.index')->with('status', 'Module create!');
    }

    public function show(Module $Module)
    {
        return view('security/modules/show',['module' => $Module]);
    }

    public function edit(Module $Module)
    {
        return view('security/modules/edit',[
            'module' => $Module,
            'parent_module' => Module::where('aplication_id',$Module->aplication_id)
                                    ->where('parent', 0)
                                    ->orderBy('name','ASC')
                                    ->pluck('name','id'),
            'aplication' => Aplication::orderBy('name','ASC')->pluck('name','id')
        ]);
    }

    public function update(SaveModuleRequest $request, Module $Module)
    {
        $Module->update($request->validated());

        return to_route('Modules.index', $Module)->with('status', 'Module updated!');
    }

    public function destroy( $id)
    {
        try {
            $Module = Module::findOrFail($id);
            $Module->delete();

            return to_route('Modules.index')->with('status',__('Module deleted!'));

        } catch (Exception $e) {
            return to_route('Modules.index')->with('errors','El módulo no puede ser eliminado.');
        }

    }

    public function findParentModuleByAplicationId($id){
        return Module::where('aplication_id',$id)
                     ->where('parent', 0)->get();
    }

    public function findModuleByParentModuleId($id){
        return Module::where('parent',$id)->get();
    }

    public function findModuleByAplicationId($id)
    {
        return Module::from('security_modules AS M')
                    ->rightjoin('security_modules AS parent', 'parent.parent', '=', 'M.id')
                    ->select("parent.id", DB::raw("(CASE WHEN parent.parent = 0 THEN parent.name ELSE (CONCAT(M.name,' - ',parent.name)) END) as name"))
                    ->where('parent.aplication_id',$id)
                    ->get();
    }

}

