<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Aplication;
use Illuminate\Http\Request;

class ManagmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if (!session('menus')) {
            return to_route('dashboard');
        };
    }

    public function index($id)
    {
        
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function show($id)
    {
        session(['aplicationActive' => $id]);

        return view('dashboard-app');
    }

    public function edit($id)
    {
    }

    public function update($request, Aplication $Aplication)
    {
    }

    public function destroy(Aplication $Aplication)
    {
    }
    public function findMenuAplicationId(Request $request)
    {
        $aplications = Aplication::select("id", "name", "icon")->where("id", "=", $request->id)->get();

        session(['menuAplication' => $aplications]);

        $modules = $this->modules($request->id);
        $menu = $this->menus($request->id);

        session (['modules' =>$modules]);
        session(['menus' => $menu]);
        
        $fechas = DB::table('fyl_fechas_entrenamientos')->get();
    
        // Almacenar fechas en la sesión
        session(['fechas' => $fechas]);
    
        return to_route('managment');
    }

    public  function getChildren($modules, $data, $line)
    {
        $children = [];

        foreach ($data as $line1) {
            if ($line->idModule == $line1->parentModule) {
                $children = array_merge($children, [array_merge(get_object_vars($line1), ['submenu' => $this->getChildren($data, $line1)])]);
            }
        }
        return $children;
    }

    public function optionsModules($id)
    {
        return DB::table('security_menu_view')
            ->select('parent','idModule','nameParent','orderModule')
            ->distinct()
            ->where("aplication_id", "=", $id)
            ->where("parent", "=", 0)
            ->where("idUser", "=", auth()->user()->id)
            ->orderby('parent')
            ->orderby('orderModule')
            ->get()
            ->toArray();
    }

    public  function modules($id)
    {
        $options = $this->optionsModules($id);
        // dd($options),
        return $options;
    }

    public function optionsMenu($id)
    {
        return DB::table('security_menu_view')
            ->select('*')
            ->distinct()
            ->where("aplication_id", "=", $id)
            ->where("idUser", "=", auth()->user()->id)
            ->orderby('orderModule')
            ->orderby('orderfunctionality')
            // ->orderby('parent')
            ->get()
            ->toArray();
    }
    public  function menus($id)
    {
        $options = $this->optionsMenu($id);
        // dd($options),
        return $options;
    }
}
