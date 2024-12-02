<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\User;
use App\Models\Users;
use App\Models\UserProfile;
use App\Models\Fyl\CampusUser;
use App\Models\ProfileFunctionality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 30;
        
        
        $profiles = DB::table('security_profiles as p')
                    ->select('p.name as perfil', 'p.id')
                    ->where('p.aplication_id', 4)
                    ->where('p.id','<>', 30)
                    ->orderBy('p.name')
                    ->get();
                    
        

        return view('fyl/profile.index',['profiles' => $profiles, 'User' => new Users]);
    }


    public function create()
    {
        
    }

    public function store(SaveCampusRequest $request)
    {
        Campus::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Campus.index')->with('status','Campus create!');
    }

    public function show(Campus $Campus)
    {
        return view('fyl/campus/show',['Campus' => $Campus]);
    }

    public function edit($id)
    {
            
        $users = DB::table('users')
            ->select('id', 'name')
            ->where('user_type', 'FYL')
            ->where('id', '>', 1)
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('user_id')
                    ->from('security_user_profiles')
                    ->where('profile_id', $id)
                    ->where('status', 'ACTIVE');
            })
            ->orderBy('name')
            ->pluck('name','id');
            
         //   return $users;
            
        $usersProfile = DB::table('security_profiles as profiles')
            ->select(
                'users.id as user_id',
                'profiles.id as perfil_id',
                'profiles.name as perfil',
                'users.name as usuario',
                'security_user_profiles.id',
                DB::raw('(SELECT count(*) FROM fyl_campus_user WHERE campus_id = 1 AND user_id = users.id) as quito'),
                DB::raw('(SELECT count(*) FROM fyl_campus_user WHERE campus_id = 2 AND user_id = users.id) as bogota'),
                DB::raw('(SELECT count(*) FROM fyl_campus_user WHERE campus_id = 3 AND user_id = users.id) as cuenca')
            )
            ->join('security_user_profiles', 'profiles.id', '=', 'security_user_profiles.profile_id')
            ->join('users', 'security_user_profiles.user_id', '=', 'users.id')
            ->where('profiles.aplication_id', 4)
            ->where('profiles.id', $id)
            ->orderBy('profiles.name', 'asc')
            ->orderBy('users.name', 'asc')
            ->get();
            
           // return $usersProfile;
        
        return view('fyl/profile.edit',['users' => $users, 'usersProfile' => $usersProfile]);
    }
    
    
    
    public function addUser(Request $request)
    {
        //return $request;
        $users = DB::table('users')
            ->select('id', 'name')
            ->where('user_type', 'FYL')
            ->where('status', 'ACTIVE')
            ->where('id', '>', 1)
            ->orderBy('name')
            ->pluck('name','id');
            
        
        $data = [
            'user_id' => $request->input('user_id'),
            'profile_id' => $request->input('profile_id'),
            'state' => 'ACTIVE'
            ];
            
        UserProfile::create($data);
        
        return to_route('ProfilesFocus.edit', $request->input('profile_id'))->with('status','Usuario agregado!');
        
    }
    
    public function editFun($id)
    {  
        $functionalities = DB::table('security_functionalities as F')
                ->join('security_modules as M', 'F.module_id', '=', 'M.id')
                ->select('F.id', DB::raw("CONCAT(M.name, ' - ', F.name) as name"))
                ->where('F.aplication_id', 4)
                ->where('F.state', 'ACTIVE')
                ->whereNotIn('F.id', function($query) use ($id) {
                    $query->select('functionality_id')
                          ->from('security_profile_functionalities')
                          ->where('profile_id', $id);
                })
                ->orderBy('M.order')
                ->orderBy('F.order')
                ->pluck('name','id');
                
        //return $functionalities;
            
        $profileFunctionalities  = DB::table('security_profile_functionalities as PF')
                ->join('security_functionalities as F', 'PF.functionality_id', '=', 'F.id')
                ->join('security_modules as M', 'F.module_id', '=', 'M.id')
                ->join('security_profiles as P', 'PF.profile_id', '=', 'P.id')
                ->select('PF.id', DB::raw("CONCAT(M.name, ' - ', F.name) as funcionalidad"), 'P.name as perfil', 'P.id as perfil_id')
                ->where('PF.aplication_id', 4)
                ->where('F.state', 'ACTIVE')
                ->where('PF.profile_id', $id)
                ->orderBy('M.order')
                ->orderBy('F.order')
                ->get();
            
            //return $profileFunctionalities;
        
        return view('fyl/profile.editFun',['functionalities' => $functionalities, 'profileFunctionalities' => $profileFunctionalities]);
    }
    
    public function addFun(Request $request)
    {
        
        $data = [
            'aplication_id' => 4,
            'profile_id' => $request->input('profile_id'),
            'functionality_id' => $request->input('functionality_id'),
            'state' => 'ACTIVE'
            ];
            
        ProfileFunctionality::create($data);
        
        return to_route('ProfilesFocus.editFun', $request->input('profile_id'))->with('status','Funcionalidad agregada!');
        
    }
    
    public function sedeUsuario($id)
    {
        try {
            
            $partes = explode('_', $id);
            
            $user_id = $partes[0];
            $campus_id = $partes[1];
            $status = $partes[2];
            $profile_id = $partes[3];
            
            if($status == 1)
            {
                CampusUser::where('campus_id', $campus_id)->where('user_id',$user_id)->delete();
                return to_route('ProfilesFocus.edit', $profile_id)->with('status','Usuario eliminado!');
            }
            else
            {
                $nuevoRegistro = new CampusUser();
                $nuevoRegistro->campus_id = $campus_id;
                $nuevoRegistro->user_id = $user_id;
                $nuevoRegistro->user_id_register = auth()->id();
                $nuevoRegistro->save();
                return to_route('ProfilesFocus.edit', $profile_id)->with('status','Usuario agregado!');
            }
                
            
            
        } catch (Exception $e) {
            return to_route('ProfilesFocus.edit')->with('errors','Algo salió mal.');
        }
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        try {
            $userProfile = UserProfile::find($id);
            
            $profile_id = $userProfile->profile_id;
            
            $userProfile->delete();
            
            return to_route('ProfilesFocus.edit', $profile_id)->with('status','Usuario eliminado!');
            
        } catch (Exception $e) {
            return to_route('ProfilesFocus.edit')->with('errors','El usuario no puede ser eliminado.');
        }

    }

    public function destroyFun($id)
    {
        try {
            $profileFunctionalities = ProfileFunctionality::find($id);
            
            $profile_id = $profileFunctionalities->profile_id;
            
            $profileFunctionalities->delete();
            
            return to_route('ProfilesFocus.editFun', $profile_id)->with('status','Usuario eliminado!');
            
        } catch (Exception $e) {
            return to_route('ProfilesFocus.editFun')->with('errors','El usuario no puede ser eliminado.');
        }

    }


}
