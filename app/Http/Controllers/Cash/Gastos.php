<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Cash\Gastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

use Illuminate\Support\Facades\Session;


class GastosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 10;
        
        //return response()->json($search);

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);
        
        //$gastos = [];
        
        $gastos = Productos::paginate($pag);
        
        //return $gastos;

        $userId = auth()->id();
        
        $gasto = [];
        

        return view('cash/gasto/index', [
            'gasto' => $gasto,
            'gastos' => $gastos]);
    }


    public function create()
    {
       
    }

    public function store(Request $request)
    {
        
        try {
            $reglas = [ 
                'fecha' => ['required','date'],
                'cat_id_tipo_gasto' => ['required', 'integer'],
                'cat_id_categoria' => ['required', 'integer'],
                'proveedor_id' => ['required', 'integer'],
                'descripcion' => ['required'],
                'total' => ['required', 'numeric', 'between:0.01,99999999.99']
            ];
            
            $mensajes = [
                'campo.required' => 'El campo es obligatorio.',
                'campo.numeric' => 'El campo debe ser un valor numérico.',
                'campo.between' => 'El campo debe estar entre :min y :max.',
            ];
            
            
            $request->validate($reglas, $mensajes);
    
    
            $dataCreate = [
                'fecha' => $request->input('fecha'),
                'cat_id_tipo_gasto' => $request->input('cat_id_tipo_gasto'),
                'cat_id_categoria' => $request->input('cat_id_categoria'),
                'proveedor_id' => $request->input('proveedor_id'),
                'descripcion' => $request->input('descripcion'),
                'total' => $request->input('total'),
                'user_id' => auth()->id()
            ];
            
            
            if($request->input('id'))
            {
                $gastos = Productos::where('id',$request->input('id'))->first();
                $gastos->update($dataCreate);
            }
            else
            {
                Gastos::create($dataCreate);
            }
            
            Session::flash('success', 'El Gasto se ha registrado correctamente.');
        
            // Redirige al índice de Empresas con un mensaje de éxito
            return redirect()->route('Gastos.index')->with('status', 'Gasto registrado correctamente!');
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            Session::flash('error', $mensaje);
            return redirect()->back()->withInput();
        }
    }

    public function show(Campus $Campus)
    {
        return view('fyl/campus/show',['Campus' => $Campus]);
    }

    public function edit(Campus $Campus)
    {
        $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('CI.id',
                  DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
                  )
        ->groupby('CI.id','CO.name', 'P.name','CI.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('CI.name','asc')->pluck('name','id');

        return view('fyl/campus/edit', [
            'city' => $city,
            'campus' => $Campus]);


        //return view('fyl/campus/edit',['Campus' => $Campus]);
    }

    public function update(Request $request, $id)
    {
        //return $request;
        $campus = Campus::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'city_id' => ['required'],
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'status' => ['required'],
        ]);

        //return $validator;

        if ($validator && $validator->fails()) {
            // Si la validaci贸n falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);

        $campus->update($data);

        return to_route('Campus.index', $campus)->with('status','Campus updated!');
    }

    public function destroy(Campus $Campus)
    {
        try {
            $Campus->delete();
        } catch (Exception $e) {
            return to_route('Campus.index')->with('errors','La Sede no puede ser eliminada.');
        }

        return to_route('Campus.index')->with('status',__('Campus deleted!'));
    }


}
