<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Cash\SaveEmpresaRequest;
use App\Models\Cash\Empresa;
use App\Models\Cash\Firma;
use App\Models\Cash\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

use Illuminate\Support\Facades\Session;


class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        //if (!session('menus')) {
          //  return to_route('dashboard');
        //};
        
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 10;
        
        //return response()->json($search);

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);
        
        //$productos = [];
        
        $productos = Productos::paginate($pag);
        
        //return $productos;

        $userId = auth()->id();
        
        $producto = [];
        

        return view('cash/producto/index', [
            'producto' => $producto,
            'productos' => $productos]);
    }


    public function create()
    {
       
    }

    public function store(Request $request)
    {
        
        try {
            $reglas = [
                'categoria_id' => ['required', 'integer'],
                'codigo' => ['required', 'numeric'],
                'nombre_producto' => ['required'],
                'tipo' => ['required'],
                'pvp_manual' => ['required'],
                'paga_impuesto' => ['required'],
                'porcentaje_iva' => ['required', 'integer'],
                'pvp1' => ['required', 'numeric', 'between:0,99999999.99'],
                'pvp2' => ['required', 'numeric', 'between:0,99999999.99'],
                'pvp3' => ['required', 'numeric', 'between:0,99999999.99'],
                'pvp4' => ['required', 'numeric', 'between:0,99999999.99'],
            ];
            
            $mensajes = [
                'campo.required' => 'El campo es obligatorio.',
                'campo.numeric' => 'El campo debe ser un valor numérico.',
                'campo.between' => 'El campo debe estar entre :min y :max.',
            ];
            
            
            $request->validate($reglas, $mensajes);
            
            $hash = hash('sha256', $request->input('codigo')); // Calcula el hash SHA-256
            $hash = substr($hash, 0, 40);
    
    
            $dataCreate = [
                'categoria_id' => $request->input('categoria_id'),
                'pos' => $hash,
                'codigo' => $request->input('codigo'),
                'nombre_producto' => $request->input('nombre_producto'),
                'tipo' => $request->input('tipo'),
                'pvp_manual' => $request->input('pvp_manual'),
                'paga_impuesto' => $request->input('paga_impuesto'),
                'porcentaje_iva' => $request->input('porcentaje_iva'),
                'pvp1' => $request->input('pvp1'),
                'pvp2' => $request->input('pvp2'),
                'pvp3' => $request->input('pvp3'),
                'pvp4' => $request->input('pvp4'),
                'user_id' => auth()->id()
            ];
            
            
            if($request->input('pos'))
            {
                $productos = Productos::where('pos',$request->input('pos'))->first();
                $productos->update($dataCreate);
            }
            else
            {
                Productos::create($dataCreate);
            }
            
            Session::flash('success', 'El Producto se ha registrado correctamente.');
        
            // Redirige al índice de Empresas con un mensaje de éxito
            return redirect()->route('Producto.index')->with('status', 'Producto created successfully!');
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            if (Str::contains($mensaje, 'Duplicate') and Str::contains($mensaje, 'codigo'))
            {
                 $mensaje = 'No se permite duplicar un código existente.'; 
            }
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
