<?php

namespace App\Http\Controllers\th;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TH\SaveDepartmentRequest;
use App\Models\TH\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $department = Department::where('th_department.name', 'LIKE', '%' . $search . '%')
                            ->orderBy('name','asc')
                            ->paginate($pag);

        $department->appends(['search' => $search, 'pag' => $pag]);

        return view('th/departments.index',['department' => $department, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('th/departments.create', [
            'department' => new Department
        ]);
    }


    public function store(SaveDepartmentRequest $request)
    {
        Department::create($request->validated());

        return to_route('Departments.index')->with('status', 'Department create!');
    }

    public function show(Department $department)
    {
        return view('th/departments.show',['department' => $department]);
    }

    public function edit( $id)
    {
        $department = Department::findOrFail($id);
        return view('th/departments.edit',[
            'department' => $department
        ]);
    }

    public function update(SaveDepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->validated());

        return to_route('Departments.index', $department)->with('status', 'Department updated!');
    }

    public function destroy( $id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            return to_route('Departments.index')->with('status',__('Department deleted!'));

        } catch (Exception $e) {
            return to_route('Departments.index')->with('errors','El cargo no puede ser eliminado.');
        }

    }

    public function findDepartment($parametro){
       // $parametro = str_replace($parametro,' ','%'),
        return Department::from('th_department AS D')
        ->select( 'D.id',
                  'D.name as label')
        ->where('D.name','LIKE', '%'.$parametro.'%')->get();
    }

}
