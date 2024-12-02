<?php
namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Security\SaveProfileRequest;
use App\Models\Aplication;
use App\Models\Profile;
use Illuminate\Http\Request;
use Exception;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $profile = Profile::from('security_profiles AS P')
                        ->join('security_aplications as A', 'A.id', '=', 'P.aplication_id')
                        ->where('P.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('A.name', 'LIKE', '%' . $search . '%')
                        ->select('P.id',
                                 'P.aplication_id',
                                 'A.name as aplication',
                                 'P.name',
                                 'P.state')
                        ->orderBy('P.aplication_id','ASC')
                        ->orderBy('A.name','ASC')
                        ->paginate($pag);

        $profile->appends(['search' => $search, 'pag' => $pag]);

        return view('security/profiles/index',['profile' => $profile, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('security/profiles/create', [
            'profile' => new Profile,
            'aplication' => Aplication::orderBy('name','ASC')->pluck('name','id')
        ]);
    }


    public function store(SaveProfileRequest $request)
    {
        Profile::create($request->validated());

        return to_route('Profiles.index')->with('status', 'Profile create!');
    }

    public function show(Profile $Profile)
    {
        return view('security/profiles/show',['profile' => $Profile]);
    }

    public function edit(Profile $Profile)
    {
        return view('security/profiles/edit',[
            'profile' => $Profile,
            'aplication' => Aplication::orderBy('name','ASC')->pluck('name','id')
        ]);
    }

    public function update(SaveProfileRequest $request, Profile $Profile)
    {
        $Profile->update($request->validated());

        return to_route('Profiles.index', $Profile)->with('status', 'Profile updated!');
    }

    public function destroy( $id)
    {
        try {
            $Profile = Profile::findOrFail($id);
            $Profile->delete();

        } catch (Exception $e) {
            return to_route('Profiles.index')->with('errors','El perfil no ser eliminado.');
        }

        return to_route('Profiles.index')->with('status','Profile deleted!');
    }

    public function findProfileByAplicationId($id){
        return Profile::where('aplication_id',$id)->get();
    }
    public function findProfileAll(){
        return Profile::from('security_profiles AS P')
                      ->join('security_aplications as A', 'A.id', '=', 'P.aplication_id')
                    ->select('P.id',
                             'P.aplication_id',
                             'A.name as aplication',
                              DB::raw("CONCAT(A.name,' - ',P.name)  as name"),
                             'P.state')->get();
    }
}
