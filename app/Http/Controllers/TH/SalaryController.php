<?php

namespace App\Http\Controllers\th;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TH\SaveSalaryRequest;
use App\Models\TH\Salary;
use Illuminate\Http\Request;
use Exception;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $salary = Salary::from('th_salaries as S')
                        ->join('th_employee_details as ED', 'S.employee_id', '=', 'ED.employee_id')
                        ->join('th_employees as E', 'S.employee_id', '=', 'E.id')
                        ->join('th_department as D', 'D.id', '=', 'ED.department_id')
                        ->join('th_job_title as JT', 'ED.job_title_id', '=', 'JT.id')
                        ->where('E.names', 'LIKE', '%' . $search . '%')
                        ->orwhere('E.surnames', 'LIKE', '%' . $search . '%')
                        ->orwhere('D.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('JT.name', 'LIKE', '%' . $search . '%')
                        ->select('S.id',
                                'S.amount',
                                'E.surnames',
                                'E.names',
                                'D.name as department',
                                'JT.name as jobTitle')
                        ->groupby('S.id','S.amount','E.surnames','E.names','JT.name')
                        ->orderBy('E.surnames','asc')
                        ->orderBy('E.names', 'asc')
                        ->paginate($pag);

        $salary->appends(['search' => $search, 'pag' => $pag]);

        return view('th/salaries.index',['salary' => $salary, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('th/salaries.create', [
            'salary' => new Salary
        ]);
    }


    public function store(SaveSalaryRequest $request)
    {
        try {
            Salary::create($request->validated());
            return to_route('Salaries.index')->with('status', 'Salary create!');
        } catch (Exception $e) {
            return to_route('Salaries.index')->with('errors','Error. Imposible registrar, verifique que el empleado no se encuentre registrado.');
        }
    }

    public function show(Salary $salary)
    {
        return view('th/salaries.show',['salary' => $salary]);
    }

    public function edit( $id)
    {
        $salary = Salary::join('th_employees as E', 'E.id', '=', 'th_salaries.employee_id')
                        ->join('th_employee_details as ED', 'ED.employee_id', '=', 'E.id')
                        ->join('th_department as D', 'D.id', '=', 'ED.department_id')
                        ->join('th_job_title as JT', 'JT.id', '=', 'ED.job_title_id')
                        ->select('E.id as employee_id',
                                  DB::raw("(CONCAT(E.surnames,' ',E.names)) as employee"),
                                  'D.name as department',
                                  'JT.name as jobTitle',
                                  'JT.minimum_salary',
                                  'JT.maximum_salary',
                                  'th_salaries.id',
                                  'th_salaries.amount')
                        ->findOrFail($id);

        return view('th/salaries/edit',[
            'salary' => $salary
        ]);



    }

    public function update(SaveSalaryRequest $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $salary->update($request->validated());

        return to_route('Salaries.index', $salary)->with('status', 'Salary updated!');
    }

    public function destroy( $id)
    {
        try {
            $salary = Salary::findOrFail($id);
            $salary->delete();

            return to_route('Salaries.index')->with('status',__('Salary deleted!'));

        } catch (Exception $e) {
            return to_route('Salaries.index')->with('errors','El cargo no puede ser eliminado.');
        }

    }

    public function findSalary($parametro){
        return Salary::from('th_Salary AS D')
        ->select( 'D.id',
                  'D.name as label')
        ->where('D.name','LIKE', '%'.$parametro.'%')->get();
    }

}
