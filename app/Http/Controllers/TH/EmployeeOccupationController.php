<?php

namespace App\Http\Controllers\TH;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TH\SaveEmployeeOccupationRequest;
use App\Models\Global\Catalog;
use App\Models\TH\Employee;
use App\Models\TH\EmployeeOccupation;
use Illuminate\Http\Request;
use Exception;
use Redirect;

class EmployeeOccupationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $employeeOccupations = EmployeeOccupation::from('th_employee_details AS EO')
                            ->join('th_employees as E', 'EO.employee_id', '=', 'E.id')
                            ->join('th_department as DE', 'EO.department_id', '=', 'DE.id')
                            ->join('th_job_title as JT', 'EO.job_title_id', '=', 'JT.id')
                            ->where('E.names', 'LIKE', '%' . $search . '%')
                            ->orwhere('E.surnames', 'LIKE', '%' . $search . '%')
                            ->orwhere('DE.name', 'LIKE', '%' . $search . '%')
                            ->orwhere('JT.name', 'LIKE', '%' . $search . '%')
                            ->select('EO.id',
                                    'EO.employee_id',
                                    'EO.evaluator',
                                    'EO.job_title_id',
                                    'EO.department_id',
                                    'EO.departure_date',
                                    'EO.status',
                                    'E.surnames',
                                    'E.names',
                                    'DE.name as department',
                                    'JT.name as jobTitle')
                            ->groupby('EO.id','EO.employee_id','EO.evaluator','EO.job_title_id','EO.department_id','EO.departure_date','EO.status','E.surnames','E.names','DE.name','JT.name')
                            ->orderBy('E.surnames','asc')
                            ->orderBy('E.names', 'asc')
                            ->paginate($pag);

        $employeeOccupations->appends(['search' => $search, 'pag' => $pag]);

        return view('th/employeeOccupations/index',['employeeOccupation' => $employeeOccupations, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('th/employeeOccupations/create', [
            'employeeOccupation' => new EmployeeOccupation,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id')
        ]);
    }

    public function store(SaveEmployeeOccupationRequest $request)
    {
        try {
            EmployeeOccupation::create($request->validated());

            return to_route('EmployeeOccupations.index')->with('status','Employee Occupation create!');

        } catch (Exception $e) {
            return to_route('EmployeeOccupations.index')->with('errors','Error. Imposible registrar, verifique que el empleado no se encuentre registrado.');
        }

    }

    public function show(EmployeeOccupation $EmployeeOccupation)
    {
        return view('th/employeeOccupations/show',['EmployeeOccupation' => $EmployeeOccupation]);
    }

    public function edit($id)
    {
        $employeeOccupation = EmployeeOccupation::join('th_employees as E', 'E.id', '=', 'th_employee_details.employee_id')
                            ->join('th_department as D', 'D.id', '=', 'th_employee_details.department_id')
                            ->join('th_job_title as JT', 'JT.id', '=', 'th_employee_details.job_title_id')
                        ->select('E.id as employee_id',
                                  DB::raw("(CONCAT(E.surnames,' ',E.names)) as employee"),
                                  'D.name as department',
                                  'JT.name as jobTitle',
                                  'th_employee_details.id',
                                  'th_employee_details.evaluator',
                                  'th_employee_details.job_title_id',
                                  'th_employee_details.department_id',
                                  'th_employee_details.entry_date',
                                  'th_employee_details.departure_date',
                                  'th_employee_details.status')
                        ->findOrFail($id);

        return view('th/employeeOccupations/edit',[
            'employeeOccupation' => $employeeOccupation
        ]);
    }

    public function update( SaveEmployeeOccupationRequest $request,$id)
    {
        try {
            $employeeOccupation = EmployeeOccupation::where('employee_id','=',$id)->first();

            $employeeOccupation->update($request->validated());

            return redirect()->back()->with('tab',2);

        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Error. Imposible registrar, verifique que el empleado no se encuentre registrado.');
        }

    }

    public function destroy(EmployeeOccupation $EmployeeOccupation)
    {
        try {
            $EmployeeOccupation->delete();
            return to_route('EmployeeOccupations.index')->with('status','Employee Occupation deleted!');

        } catch (Exception $e) {
            return to_route('EmployeeOccupations.index')->with('errors','La funcionalidad no puede ser eliminada.');
        }
    }

    public function findEmployeeOccupationByAplicationId($id){
        return EmployeeOccupation::where('aplication_id',$id)->get();
    }

    public function findEmployeeDetails($parametro){
        return Employee::from('th_employees AS E')
        ->join('th_employee_details as ED', 'E.id', '=', 'ED.employee_id')
        ->join('th_department as D', 'D.id', '=', 'ED.department_id')
        ->join('th_job_title as JT', 'JT.id', '=', 'ED.job_title_id')
        ->select( 'E.id',
                  DB::raw("(CONCAT(E.surnames,' ',E.names)) as label"),
                  'minimum_salary',
                  'maximum_salary')
        ->where('surnames','LIKE', '%'.$parametro.'%')->get();
    }

}
