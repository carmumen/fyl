<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Security\SaveUserProfileRequest;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Psr7\Message;

class UserProfilesController extends Controller
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

        $UserProfiles = UserProfile::from('security_user_profiles AS UP')
                        ->join('users as U', 'U.id', '=', 'UP.user_id')
                        ->join('security_profiles as P', 'P.id', '=', 'UP.profile_id')
                        ->join('security_aplications as A', 'P.aplication_id', '=', 'A.id')
                        ->where('U.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('P.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('A.name', 'LIKE', '%' . $search . '%')
                        ->select('UP.id',
                                 'UP.user_id',
                                 'UP.profile_id',
                                 'U.name as user',
                                  DB::raw("CONCAT(A.name,' - ',P.name)  as profile"),
                                //  'P.name as profile',
                                 'UP.state')
                        ->orderBy('A.name','ASC','P.name','ASC')
                        ->paginate($pag);

        $UserProfiles->appends(['search' => $search, 'pag' => $pag]);

        return view('security/userProfiles/index',['userProfiles' => $UserProfiles, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('security/userProfiles/create', [
            'profile' => [],
            'user' => [],
            'userProfile' => new userProfile
        ]);
    }

    public function store(SaveUserProfileRequest $request)
    {
        try {
        UserProfile::create($request->validated());
        } catch (Exception $e) {
            report($e);

            return to_route('UserProfiles.index')->with('status','Error'+$e->getMessage());
        }
        return to_route('UserProfiles.index')->with('status', 'User Profile create!');
    }

    public function show(Profile $userProfile)
    {
        return view('security/userProfiles/show',['profile' => $userProfile]);
    }

    public function edit($id)
    {
        $userProfile = UserProfile::findOrFail($id);
        return view('security/userProfiles/edit', [
            'userProfile' => $userProfile,
            'user' => User::where('status','ACTIVE')->where('user_type','FYL')->orderby('name','asc')->pluck('name','id'),
            'profile' => Profile::from('security_profiles AS P')
                                ->join('security_aplications as A', 'A.id', '=', 'P.aplication_id')
                                ->select('P.id',
                                         'P.state',
                                          DB::raw("CONCAT(A.name,' - ',P.name)  as name"))
                                ->where('P.state','ACTIVE')->pluck('name','id')
        ]);
    }

    public function update(SaveUserProfileRequest $request, $id)
    {
        try{
            $userProfile = UserProfile::findOrFail($id);
            $userProfile->update($request->validated());

            return to_route('UserProfiles.index', $userProfile)->with('status', 'User Profile updated!');

        } catch (Exception $e) {
            return to_route('UserProfiles.index')->with('errors','La relación Perfil funcionalidad ya existe');
        }


    }

    public function destroy( $id)
    {
        try {
            $userProfile = UserProfile::findOrFail($id);
            $userProfile->delete();

            return to_route('UserProfiles.index')->with('status','User Profile deleted!');

        } catch (Exception $e) {
            return to_route('UserProfiles.index')->with('errors','La relación usuario-perfil no ser eliminada.');
        }
    }
}
