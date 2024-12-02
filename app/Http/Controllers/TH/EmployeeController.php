<?php

namespace App\Http\Controllers\TH;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TH\SaveEmployeeRequest;
use App\Models\Global\Catalog;
use App\Models\TH\Department;
use App\Models\TH\JobTitle;
use App\Models\Global\City;
use App\Models\TH\Employee;
use App\Models\TH\AcademicTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use Session;
use Exception;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        //Session::forget('tab');
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $employees = Employee::from('th_employees AS E')
                            ->leftjoin('global_catalogs as G', 'G.id', '=', 'E.gender_catalog_id')
                            ->leftjoin('global_catalogs as CS', 'CS.id', '=', 'E.civil_status_catalog_id')
                            ->where('E.names', 'LIKE', '%' . $search . '%')
                            ->orwhere('E.surnames', 'LIKE', '%' . $search . '%')
                            ->orwhere('E.email', 'LIKE', '%' . $search . '%')
                            ->orwhere('G.name', 'LIKE', '%' . $search . '%')
                            ->orwhere('CS.name', 'LIKE', '%' . $search . '%')
                            ->select('E.id',
                                    'E.DNI',
                                    'E.names',
                                    'E.surnames',
                                    'E.birthdate',
                                    'E.gender_catalog_id',
                                    'E.civil_status_catalog_id',
                                    'E.city_of_residence',
                                    'E.address',
                                    'E.phone',
                                    'E.email',
                                    'E.status',
                                    'G.name as gender',
                                    'CS.name as civil_status')
                            //->groupby('E.id','E.DNI','E.names','E.surnames','E.birthdate','E.gender_catalog_id','E.civil_status_catalog_id','E.address','E.phone','E.email','E.status','G.name','CS.name')
                            ->orderBy('E.surnames','asc')
                            ->orderBy('E.names', 'asc')
                            ->paginate($pag);

        $employees->appends(['search' => $search, 'pag' => $pag]);

        return view('th/employees/index',['employee' => $employees, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('th/employees/create', [
            'employee' => new Employee,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
            'department' => Department::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
            'jobTitle' => JobTitle::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
        ]);
    }


public function store(Request $request)
{
    try
    {
        session()->flash('tab', 2);
        $validator = Validator::make($request->all(), [
            'DNI' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('th_employees')->where(function ($query) use ($request) {
                    return $query
                        ->where('id', $request->input('DNI'))
                        ->whereNotIn('id', [$request->input('id')]);
                }),
            ],
            'names' => ['required', 'min:4'],
            'surnames' => ['required', 'min:4'],
            'is_user' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
            'status' => ['required']
        ]);
    
        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $request->except(['_token', 'tagName']);
        
        
        $existe = Employee::where('dni', $request->DNI)->first();
        
        
        
        if($existe)
        {
            $mensaje = 'El DNI ya se ecuentra registrado';
            $validator->errors()->add('DNI', $mensaje);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $employee = Employee::create($data);
        
        
        $employees = Employee::where('dni', $request->DNI)->firstOrFail();
        
        $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('CI.id',
                  DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
                  )
        ->groupby('CI.id','CO.name', 'P.name','CI.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('CI.name','asc')->pluck('name','id');
        
        $academicTraining = AcademicTraining::from('th_academic_training as A')
        ->join('global_catalogs as C', 'C.id', '=', 'A.education_level')
        ->select('A.id',
                 'A.employee_id',
                 'A.education_level',
                 'A.institution',
                 'A.specialty',
                 'A.country_and_city',
                 'A.ending_year',
                 'C.name')
        ->where('employee_id', $employee->id)
        ->orderByRaw('A.education_level * 1 asc')
        ->get();
    
        return view('th/employees/edit',[
            'employee' => $employees,
            'academicTraining' => $academicTraining,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),

            'city_of_residence' => $city,
            'education_level' => Catalog::where('catalog_types_id',3)->pluck('name','id'),
            'department' => Department::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
            'jobTitle' => JobTitle::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
        ]);
    }
    catch (Exception $e) {
        return redirect()->back()->withErrors([$e->getMessage()])->withInput();
    }

}


public function show(Employee $Employee)
{
    return view('th/employees/show',['Employee' => $Employee]);
}

public function edit($id)
{
    $employee = Employee::findOrFail($id);

    $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('CI.id',
                  DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
                  )
        ->groupby('CI.id','CO.name', 'P.name','CI.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('CI.name','asc')->pluck('name','id');

    $academicTraining = AcademicTraining::from('th_academic_training as A')
        ->join('global_catalogs as C', 'C.id', '=', 'A.education_level')
        ->select('A.id',
                 'A.employee_id',
                 'A.education_level',
                 'A.institution',
                 'A.specialty',
                 'A.country_and_city',
                 'A.ending_year',
                 'C.name')
        ->where('employee_id', $employee->id)
        ->orderByRaw('A.education_level * 1 asc')
        ->get();

        //return $academicTraining;

    return view('th/employees/edit',[
        'employee' => $employee,
        'academicTraining' => $academicTraining,
        'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
        'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
        'city_of_residence' => $city,
        'education_level' => Catalog::where('catalog_types_id',3)->pluck('name','id'),
        'department' => Department::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
        'jobTitle' => JobTitle::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
    ]);
}


public function update(Request $request, $id)
{
    $validator = null;
    $tagName = $request->tagName;
    //$AcademicTraining = AcademicTraining::where('employee_id','=',$id)->first();
    $employee = Employee::findOrFail($id);
    //return $id;
    switch($tagName)
    {
        case 1:
            session()->flash('tab', 1);
            $validator = Validator::make($request->all(), [
                'DNI' => [
                    'required',
                    'regex:/^[0-9]{8,13}$/',
                    Rule::unique('th_employees')->where(function ($query) use ($request) {
                        return $query
                            ->where('id', $request->input('DNI'))
                            ->whereNotIn('id', [$request->input('id')]);
                    }),
                ],
                'names' => ['required', 'min:4'],
                'surnames' => ['required', 'min:4'],
                'is_user' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
                'status' => ['required']
            ]);
            break;
        case 2:
            session()->flash('tab', 2);
            $validator = Validator::make($request->all(), [
                'department_id' => ['required'],
                'job_title_id' => ['required'],
            ]);
            break;
        case 3:
            session()->flash('tab', 3);
            $validator = Validator::make($request->all(), [
                'gender_catalog_id' => ['required'],
                'civil_status_catalog_id' => ['required'],
                'birthdate' => ['required'],
                'city_of_residence' => ['required'],
                'address' => ['required'],
            ]);
            break;
        case 4:
            session()->flash('tab', 4);
            $validator = Validator::make($request->all(), [
                'education_level' => ['required'],
                'specialty' => ['required'],
                'institution' => ['required'],
                'country_and_city' => ['required'],
                'ending_year' => ['required'],
            ]);
            break;
        default:
            // Acción predeterminada si el tipo no coincide con ninguno de los casos anteriores
            return response()->json(['error' => 'Tipo de solicitud no válido'], 400);
    }



    if ($validator && $validator->fails()) {
        // Si la validación falla, redirige o muestra los errores
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $data = $request->except(['_token', 'tagName','_method']);

    switch($tagName)
    {
        case 1:
        case 2:
        case 3:
            $employee->update($data);
            break;
        case 4:
            AcademicTraining::create($data);
            session()->flash('tab', 4);
            break;
        default:

    }

    $academicTraining = AcademicTraining::from('th_academic_training as A')
                            ->join('global_catalogs as C', 'C.id', '=', 'A.education_level')
                            ->where('employee_id', $request->employee_id)
                            ->orderBy('A.education_level','asc')->get();

    return redirect()->back()->with([
        'employee' => $employee,
        'academicTraining' => $academicTraining,
        'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
        'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
        'department' => Department::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
        'jobTitle' => JobTitle::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
    ]);
}

    public function destroy(Employee $Employee)
    {
        try {
            $Employee->delete();

            return to_route('Employees.index')->with('status','Employee deleted!');

        } catch (Exception $e) {
            return to_route('Employees.index')->with('errors','La funcionalidad no puede ser eliminada.');
        }
    }

    public function destroyAcademicTraining($id)
    {
        try {

            $academicTraining = AcademicTraining::findOrFail($id);

            $employee = Employee::findOrFail($academicTraining->employee_id);

            $academicTraining->delete();

            session()->flash('tab', 4);

            $academicTraining = AcademicTraining::from('th_academic_training as A')
                    ->join('global_catalogs as C', 'C.id', '=', 'A.education_level')
                    ->select('A.id',
                            'A.employee_id',
                            'A.education_level',
                            'A.institution',
                            'A.specialty',
                            'A.country_and_city',
                            'A.ending_year',
                            'C.name')
                    ->where('employee_id', $employee->id)
                    ->orderByRaw('A.education_level * 1 asc')
                    ->get();

            return redirect()->back()->with([
                'employee' => $employee,
                'academicTraining' => $academicTraining,
                'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
                'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
                'department' => Department::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
                'jobTitle' => JobTitle::orderBy('name','ASC')->where('status','=','ACTIVE')->pluck('name','id'),
            ]);

            //return to_route('Employees.index')->with('status','Employee deleted!');

        } catch (Exception $e) {
            return to_route('Employees.index')->with('errors','El registro no puede ser eliminado.'. $e->getMessage());
        }
    }


    public function findEmployeeByAplicationId($id){
        return Employee::where('aplication_id',$id)->get();
    }

    public function findEmployee($parametro){
        return Employee::from('th_employees AS E')
        ->leftjoin('th_employee_details as ED', 'E.id', '=', 'ED.employee_id')
        ->leftjoin('th_department as D', 'D.id', '=', 'ED.department_id')
        ->leftjoin('th_job_title as JT', 'JT.id', '=', 'ED.job_title_id')
        ->select( 'E.id',
                  DB::raw("(CONCAT(E.surnames,' ',E.names)) as label"),
                  'minimum_salary',
                  'maximum_salary')
        ->where('surnames','LIKE', '%'.$parametro.'%')->get();
    }

    public function findEmployeeForId($id){

        return $id;
        $employee = Employee::from('th_employees as E')
                    ->leftjoin('global_catalogs as G', 'G.id', '=', 'E.gender_catalog_id')
                    ->leftjoin('global_catalogs as CS', 'CS.id', '=', 'E.civil_status_catalog_id')
                    ->leftjoin('th_employee_details as ED', 'E.id', '=', 'ED.employee_id')
                    ->leftjoin('th_department as D', 'D.id', '=', 'ED.department_id')
                    ->leftjoin('th_job_title as JT', 'JT.id', '=', 'ED.job_title_id')
                    ->select('E.id',
                                'E.DNI',
                                'E.names',
                                'E.surnames',
                                'E.birthdate',
                                'E.gender_catalog_id',
                                'E.civil_status_catalog_id',
                                'E.address',
                                'E.phone',
                                'E.email',
                                'E.status',
                                'G.name as gender',
                                'CS.name as civil_status',
                                DB::raw("(CONCAT(E.surnames,' ',E.names)) as employee"),
                                'D.name as department',
                                'JT.name as jobTitle',
                                'E.id as employee_id',
                                'ED.evaluator',
                                'ED.job_title_id',
                                'ED.department_id',
                                'ED.entry_date',
                                'ED.departure_date')
                    ->where('E.id','=',$id)
                    ->orwhere('E.DNI','=',$id)->first();
        return $employee;

    }

}
