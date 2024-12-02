<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Cash\SaveSuppliersRequest;
use App\Models\Cash\Proveedor;
use App\Models\Global\CatalogType;
use App\Models\Fyl\Campus;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class ProveedoresController extends Controller
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

         $user_id = auth()->id();
        
        $campuses = Users::find($user_id)->campuses()->pluck('fyl_campus.id')->toArray();
        
        //return $campuses;
        
        $proveedores = Proveedor::select('cash_proveedor.id','fyl_campus.name',
                        DB::raw("CONCAT(fyl_campus.pais, ' - ', fyl_campus.name) AS sede"),
                        DB::raw("CASE cash_proveedor.tipo_identidad WHEN 1 THEN 'CEDULA' WHEN 2 THEN 'RUC' END AS tipo_identidad"),
                        'cash_proveedor.identidad',
                        'cash_proveedor.nombre_comercial',
                        'cash_proveedor.direccion',
                        'cash_proveedor.email',
                        'cash_proveedor.telefono',
                        'cash_proveedor.estado')
                ->join('fyl_campus', 'cash_proveedor.campus_id', '=', 'fyl_campus.id')
                ->whereIn('fyl_campus.id', $campuses)
                ->where(function ($query) use ($search) {
                    $query->where('cash_proveedor.nombre_comercial', 'LIKE', '%' . $search . '%')
                          ->orWhere('cash_proveedor.email', 'LIKE', '%' . $search . '%')
                          ->orWhere('fyl_campus.name', 'LIKE', '%' . $search . '%');
                })
                ->paginate(30);

        $proveedores->appends(['search' => $search, 'pag' => $pag]);

        return view('cash/proveedor.index',['proveedores' => $proveedores, 'search' => $search, 'pag' => $pag]);
    }


    public function create()
    {
        $campus = Campus::where('status', 'ACTIVE')
                ->pluck(\DB::raw("CONCAT(pais, ' - ', name) AS name"), 'id');
                
        $ids = [13, 14, 15, 16, 17];
        
        $tipo_gasto = CatalogType::whereIn('id', $ids)
                    ->orderBy('name','ASC')->pluck('name','id');
                
        return view('cash/proveedor/create', [
            'campus' => $campus,
            'tipo_gasto' => $tipo_gasto,
            'proveedor' => new Proveedor]);
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'campus_id' => ['required'],
            'tipo_identidad' => ['required'],
            'identidad' => ['required'],
            'nombre_comercial' => ['required'],
            'direccion' => ['nullable'],
            'nombre_comercial' => ['nullable'],
            'email' => ['nullable','email'],
            'telefono' => ['nullable'],
            'estado' => ['required'],
        ]);


        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);

        Proveedor::create($data + ['user_id' => auth()->id()]);

        return to_route('Proveedores.index')->with('status','Proveedor creado!');
    }

    public function show(Proveedor $Proveedor)
    {
        return view('cash/proveedor/show',['Proveedor' => $Proveedor]);
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        $campusId = $proveedor->campus_id;
        
        $campus = Campus::where('status', 'ACTIVE')
                ->pluck(\DB::raw("CONCAT(pais, ' - ', name) AS name"), 'id');
                
        $ids = [13, 14, 15, 16, 17];
        
        $tipo_gasto = CatalogType::whereIn('id', $ids)
                    ->orderBy('name','ASC')->pluck('name','id');
                    
        return view('cash/proveedor/edit', [
            'campus' => $campus,
            'proveedor' => $proveedor,
            'campusId' => $campusId]);

    }

    public function update(Request $request)
    {
        $proveedor = Proveedor::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'campus_id' => ['required'],
            'tipo_identidad' => ['required'],
            'identidad' => ['required'],
            'nombre_comercial' => ['required'],
            'direccion' => ['nullable'],
            'nombre_comercial' => ['nullable'],
            'email' => ['nullable','email'],
            'telefono' => ['nullable'],
            'estado' => ['required'],
        ]);


        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);

        $proveedor->update($data);

        return to_route('Proveedores.index', $proveedor)->with('status','Proveedor updated!');
    }

    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->delete();
        } catch (Exception $e) {
            return to_route('Proveedores.index')->with('errors','EL Proveedor no puede ser eliminado.');
        }

        return to_route('Proveedores.index')->with('status',__('Proveedor deleted!'));
    }


}
