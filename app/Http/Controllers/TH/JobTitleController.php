<?php

namespace App\Http\Controllers\th;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TH\SaveJobTitleRequest;
use App\Models\TH\JobTitle;
use Illuminate\Http\Request;
use Exception;

class JobTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $jobTitle = JobTitle::where('th_job_title.name', 'LIKE', '%' . $search . '%')
                                ->paginate($pag);

        $jobTitle->appends(['search' => $search, 'pag' => $pag]);

        return view('th/jobTitles.index',['jobTitle' => $jobTitle, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('th/jobTitles.create', [
            'jobTitle' => new JobTitle
        ]);
    }


    public function store(SaveJobTitleRequest $request)
    {
        JobTitle::create($request->validated());

        return to_route('JobTitles.index')->with('status', 'Job Title create!');
    }

    public function show(JobTitle $jobTitle)
    {
        return view('th/jobTitles.show',['jobTitle' => $jobTitle]);
    }

    public function edit( $id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        return view('th/jobTitles.edit',[
            'jobTitle' => $jobTitle
        ]);
    }

    public function update(SaveJobTitleRequest $request, $id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        $jobTitle->update($request->validated());

        return to_route('JobTitles.index', $jobTitle)->with('status', 'Job Title updated!');
    }

    public function destroy( $id)
    {
        try {
            $jobTitle = JobTitle::findOrFail($id);
            $jobTitle->delete();

            return to_route('JobTitles.index')->with('status',__('Job Title deleted!'));

        } catch (Exception $e) {
            return to_route('JobTitles.index')->with('errors','El cargo no puede ser eliminado.');
        }

    }

    public function findJobTitle($parametro){
        //$parametro = str_replace($parametro,' ','%'),
        return JobTitle::from('th_job_title AS JT')
        ->select( 'JT.id',
                  'JT.name as label')
        ->where('JT.name','LIKE', '%'.$parametro.'%')->get();
    }

}
