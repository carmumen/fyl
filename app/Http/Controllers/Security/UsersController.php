<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveUserRequest;
use App\Models\Users;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 100;

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);

        $User = Users::where('users.name', 'LIKE', '%' . $search . '%')
                        ->where('user_type','FYL')
                        ->where('users.email', 'LIKE', '%' . $search . '%')
                        ->orderBy('user_type','ASC')
                        ->orderBy('name','ASC')
        ->paginate($pag);

        $User->appends(['search' => $search, 'pag' => $pag]);

        return view('security/users/index',['User' => $User, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('security/users/create', [
            'User' => new Users
        ]);
    }


    public function store(SaveUserRequest $request)
    {
        Users::create($request->validated()+['status' => 'ACTIVE', 'password' => 'SIN PASSWORD','user_type' => 'FYL']);

        return to_route('Users.index')->with('status', 'User create!');
    }

    public function show(Users $User)
    {
        return view('security/users/show',['User' => $User]);
    }

    public function edit(Users $User)
    {
        return view('security/users/edit',[
            'User' => $User
        ]);
    }

    public function update( SaveUserRequest $request, Users $User)
    {
        $User->update($request->validated());

        return to_route('Users.index', $User)->with('status', 'User updated!');
    }

    public function destroy( $id)
    {
        try {
            $User = Users::findOrFail($id);
            $User->delete();

        } catch (Exception $e) {
            return to_route('Users.index')->with('errors','El módulo no puede ser eliminado.');
        }

        return to_route('Users.index')->with('status','User deleted!');
    }

    public function findUserAll(){
        return Users::where('user_type','FYL')->orderby('name','asc')->get();
        
        return User::where('status','ACTIVE')->where('user_type','FYL')->orderby('name','asc')->pluck('name','id');
    }
}
