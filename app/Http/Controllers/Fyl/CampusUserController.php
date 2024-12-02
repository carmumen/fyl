<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveCampusUserRequest;
use App\Models\Fyl\CampusUser;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Config;
use Exception;

class CampusUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        $search = $request->input('search');
        $pag = $request->input('pag') ?: 30;

        $campuses = DB::table('fyl_campus AS C')
            ->select('C.id', 'C.pais', 'C.name', 'C.address', 'C.phone', 'C.status', 'CI.name AS city')
            ->selectRaw('(SELECT COUNT(*) FROM fyl_campus_user WHERE campus_id = C.id) as cant')
            ->join('global_cities AS CI', 'C.city_id', '=', 'CI.id')
            ->orderBy('C.name', 'asc')
            ->get();

        return view('fyl/campusUser.index', ['campus' => $campuses, 'search' => $search, 'pag' => $pag]);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        $campus_id = $request->input('campus_id');
        $selectedUsers = $request->input('selected_users');

        if ($selectedUsers) {
            // Eliminar registros existentes para el campus y los empleados
            CampusUser::where('campus_id', $campus_id)->delete();

            if($selectedUsers){
                foreach ($selectedUsers as $user_id) {
                    $nuevoRegistro = new CampusUser();
                    $nuevoRegistro->campus_id = $campus_id;
                    $nuevoRegistro->user_id = $user_id;
                    $nuevoRegistro->user_id_register = auth()->id();
                    $nuevoRegistro->save();
                }
            }

            return redirect()->route('CampusUser.index')->with('status', 'Campus User create!');
        } else {
            CampusUser::where('campus_id', $campus_id)->delete();
            return redirect()->route('CampusUser.index')->with('status', 'Campus User deleted!');
            // Si no se seleccionaron empleados, puedes manejarlo de acuerdo a tus necesidades
        }
    }

    public function show(CampusUser $CampusUser)
    {
    }

    public function edit($id)
    {
            $results = DB::select(
                'CALL fyl_get_user_for_campus(?)',
                [
                    $id
                ]
            );

            return view('fyl/campusUser/edit', [
                'campusUser' => $results,
            ]);

    }

    public function update(Request $request, $id)
    {
    }

    public function destroy(CampusUser $CampusUser)
    {
    }
}
