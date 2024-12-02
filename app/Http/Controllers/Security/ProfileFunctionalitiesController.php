<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Security\SaveProfileFunctionalitiesRequest;
use App\Models\Aplication;
use App\Models\Profile;
use App\Models\Functionality;
use App\Models\ProfileFunctionality;
use Illuminate\Http\Request;
use Exception;


class ProfileFunctionalitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 200;

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);

        $profileFunctionality = ProfileFunctionality::from('security_profile_functionalities AS FP')
                        ->join('security_aplications as A', 'A.id', '=', 'FP.aplication_id')
                        ->join('security_functionalities as F', 'F.id', '=', 'FP.functionality_id')
                        ->join('security_modules as M', 'F.module_id', '=', 'M.id')
                        ->join('security_profiles as P', 'P.id', '=', 'FP.profile_id')
                        ->where('A.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('F.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('P.name', 'LIKE', '%' . $search . '%')
                        ->select('FP.id',
                                 'FP.aplication_id',
                                 'FP.functionality_id',
                                 'FP.profile_id',
                                 'A.name as aplication',
                                 'F.name as functionality',
                                 'M.name as module',
                                 'P.name as profile',
                                 'FP.state')
                        ->orderBy('A.name','ASC')
                        ->orderBy('P.name','ASC')
                        ->orderBy('M.name','ASC')
                        ->orderBy('F.order','ASC')
                        ->orderBy('P.name','ASC')
                        ->paginate($pag);

        $profileFunctionality->appends(['search' => $search, 'pag' => $pag]);

        return view('security/profileFunctionalities/index',['profileFunctionalities' => $profileFunctionality, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('security/profileFunctionalities/create', [
            'profile' => [],
            'functionality' => [],
            'profileFunctionalities' => new ProfileFunctionality,
            'aplication' => Aplication::orderBy('name','ASC')->pluck('name','id')
        ]);
    }

    public function store(SaveProfileFunctionalitiesRequest $request)
    {
        try
        {
            ProfileFunctionality::create($request->validated());
            return to_route('ProfileFunctionalities.index')->with('status', 'Functionality Profile create!');
        }
        catch (Exception $e)
        {
            return to_route('ProfileFunctionalities.index')->with('errors','Error en aplicativo.');
        }
    }

    public function show(Profile $profileFunctionality)
    {
        return view('security/profileFunctionalities/show',['profile' => $profileFunctionality]);
    }

    public function edit($id)
    {
        $profileFunctionality = ProfileFunctionality::findOrFail($id);
        return view('security/profileFunctionalities/edit', [
            'profileFunctionalities' => $profileFunctionality,
            'functionality' => Functionality::where('aplication_id', $profileFunctionality->aplication_id)->pluck('name','id'),
            'profile' => Profile::where('aplication_id',$profileFunctionality->aplication_id)->pluck('name','id'),
            'aplication' => Aplication::orderBy('name','ASC')->pluck('name','id')
        ]);
    }

    public function update(SaveProfileFunctionalitiesRequest $request, $id)
    {
        try{
        $profileFunctionality = ProfileFunctionality::findOrFail($id);
        $profileFunctionality->update($request->validated());
        } catch (Exception $e) {
            return to_route('ProfileFunctionalities.index')->with('errors','La relación Perfil funcionalidad ya existe');
        }


        return to_route('ProfileFunctionalities.index', $profileFunctionality)->with('status', 'Functionality Profile updated!');
    }

    public function destroy( $id)
    {
        try {
            $profileFunctionality = ProfileFunctionality::findOrFail($id);
            $profileFunctionality->delete();

        } catch (Exception $e) {
            return to_route('ProfileFunctionalities.index')->with('errors','La relación funcionalidad-perfil no ser eliminada.');
        }

        return to_route('ProfileFunctionalities.index')->with('status','Functionality Profile deleted!');
    }
}
