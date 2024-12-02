<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\Security\SaveAplicationRequest;
use App\Models\Aplication;
use App\Models\User;
//use App\Models\Aplication;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;

class AplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        if(!session('menus'))
        {
            return to_route('dashboard');
        };

    }

    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['index','show']]),
    // }

    public function index()
    {
        $aplications = Aplication::withCount('Module')->get();
        //return $aplications,
        return view('security/aplications/index',['aplication' => $aplications]);
    }

    public function create()
    {
        return view('security/aplications/create', ['Aplication' => new Aplication]);
    }

    public function store(SaveAplicationRequest $request)
    {
        Aplication::create($request->validated());

        return to_route('Aplications.index')->with('status','Aplication create!');
    }

    public function show(Aplication $Aplication)
    {
        return view('security/aplications/show',['Aplication' => $Aplication]);
    }

    public function edit(Aplication $Aplication)
    {
        return view('security/aplications/edit',['Aplication' => $Aplication]);
    }

    public function update(SaveAplicationRequest $request, Aplication $Aplication)
    {
        $Aplication->update($request->validated());

        return to_route('Aplications.index', $Aplication)->with('status','Aplication updated!');
    }

    public function destroy(Aplication $Aplication)
    {
        try {
            $Aplication->delete();

        } catch (Exception $e) {
            return to_route('Aplications.index')->with('errors','La aplicación no puede ser eliminada.');
        }

        return to_route('Aplications.index')->with('status',__('Aplication deleted!'));
    }

    public function findAplicationUser()
    {

        return Aplication::from('security_aplications AS A')
        ->join('security_functionalities AS F', 'A.id', '=', 'F.aplication_id')
        ->join('security_profiles AS P', 'A.id', '=', 'P.aplication_id')
        ->join('security_user_profiles AS UP', 'P.id', '=', 'UP.profile_id')
        ->select('A.id',
                  'A.icon',
                  'A.name',
                  'A.description',
                  'A.start_path',
                  'A.state')
        // ->where('A.state', '=', 'ACTIVE')
        ->where('UP.user_id', '=', auth()->user()->id)
        ->groupby('A.id','A.name','A.icon','A.description','A.start_path','A.state')
        ->orderBy('A.name','asc')
        ->get();
    }
}
