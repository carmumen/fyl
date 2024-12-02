<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Cash\Gastos;
use App\Models\Cash\GastosLista;
use App\Models\Cash\Proveedor;
use App\Models\Global\CatalogType;
use App\Models\Global\Catalog;

use App\Models\Fyl\Campus;
use App\Models\Fyl\CampusUser;

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
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $requestData = $request->all();
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 12;
        
        //return response()->json($search);

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);
        
        $userId = auth()->id();
            
        $campus = Campus::join('fyl_campus_user as cu', 'fyl_campus.id', '=', 'cu.campus_id')
            ->where('cu.user_id', $userId)
            ->select(DB::raw("CONCAT(UPPER(fyl_campus.pais), ' - ', fyl_campus.name) AS name"), 'fyl_campus.id')
            ->pluck('fyl_campus.name', 'fyl_campus.id');
        
        $activeTab = 'tab4';
            
        if (empty($requestData)) {
            
            return view('cash/gastos/index', [
                'campus' => $campus,
                'campusId' => 0,
                'activeTab' => $activeTab,
            ]);
        }
        
        $activeTab = $request->input('active_tab_id');
        
        $campusId = $request->input('campus_id');

        $ids = [13, 14, 15, 16, 17];
        
        $tipo_gasto = CatalogType::whereIn('id', $ids)
                    ->orderBy('name','ASC')->pluck('name','id');
                    
        $proveedor = $this->obtenerProveedor($campusId);
        //return $proveedor;
             
        
        $gastos = GastosLista::where('campus_id',$campusId)->paginate($pag);
        
        
        //return $gastos;

        $userId = auth()->id();
        
        $gasto = [];
       

        return view('cash/gastos/index', [
            'campusId' => $campusId,
            'campus' => $campus,
            'proveedor' => $proveedor,
            'tipo_gasto' => $tipo_gasto,
            'gasto' => $gasto,
            'gastos' => $gastos,
            'activeTab' => $activeTab
        ]);
    }
    
    public function proveedor(Request $request)
    {
        $term = $request->input('term');
    
        $resultados = Proveedor::where('nombre_comercial', 'LIKE', '%' . $term . '%')->get(['identidad', 'nombre_comercial']);
    
        $data = [];
    
        foreach ($resultados as $proveedor) {
            $data[] = [
                'id' => $proveedor->identidad,
                'label' => $proveedor->nombre_comercial
            ];
        }
    
        return response()->json($data);
    }



    public function obtenerProveedor($campusId)
    {
       return Proveedor::select('identidad', 'nombre_comercial')
            ->where('campus_id', $campusId)
            ->where('estado', 'ACTIVO')
            ->orderBy('nombre_comercial')
            ->pluck('nombre_comercial','identidad');   
    }
    
    public function obtenerProveedorJson()
    {
        $proveedores = Proveedor::select('identidad', 'nombre_comercial')
                    ->where('estado', 'ACTIVO')
                    ->orderBy('nombre_comercial')
                    ->get();
    
        return response()->json($proveedores);
    }
    
    
    
    public function obtenerEstadoCuenta(Request $request)
    {
        
        $campusId = $request->input('campus_id');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        
        $result = DB::select('CALL cash_estado_cuenta(?,?,?)', [$campusId,$fechaInicio,$fechaFin]);
    
        return response()->json($result);
    }
    
    
    public function obtenerIngresos(Request $request)
    {
        
        $campusId = $request->input('campus_id');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        
        $result = DB::select('CALL fyl_ingresos_por_fechas(?,?,?)', [$campusId,$fechaInicio,$fechaFin]);
    
        return response()->json($result);
    }
    
    
    public function obtenerEgresos(Request $request)
    {
        $campusId = $request->input('campus_id');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        
        //$result = DB::select('CALL cash_egresos_por_fechas(?,?,?)', [$campusId,$fechaInicio,$fechaFin]);
        
        $result = GastosLista::where('campus_id',$campusId)
                                ->where('fecha','>=',$fechaInicio)
                                ->where('fecha','<=',$fechaFin)
                                ->get();
        
        //cash_obtener_gastos
    
        return response()->json($result);
    }



    public function create()
    {
       
    }

    public function store(Request $request)
    {
        
        //return $request;
        
        try {
            $reglas = [
                'campus_id' => ['required'],
                'fecha' => ['required','date'],
                'cat_id_tipo_gasto' => ['required', 'integer'],
                'cat_id_categoria' => ['required', 'integer'],
                'proveedor_id' => ['required', 'numeric'],
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
                'campus_id' => $request->input('campus_id'),
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
                $gastos = Gastos::where('id',$request->input('id'))->first();
                $gastos->update($dataCreate);
            }
            else
            {
                Gastos::create($dataCreate);
            }
            
            Session::flash('success', 'El Gasto se ha registrado correctamente.');
        
            // Redirige al índice de Empresas con un mensaje de éxito
            return redirect()->route('Gastos.index',[
                                        'campus_id' => $request->input('campus_id'),
                                        'active_tab_id'=>'tab4' ]
                                    )->with('status', 'Gasto registrado correctamente!');
            
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
    
    public function buscaCategoria($id)
    {
        return DB::table('global_catalogs_view')->where('catalog_types_id', $id)->get();
        
    }
    
    public function crearCategoria(Request $request)
    {
        try {
            $reglas = [
                'tipo-gasto' => ['required'],
                'nueva-categoria' => ['required'],
            ];
            
            $mensajes = [
                'campo.required' => 'El campo es obligatorio.',
            ];
            
            
            $request->validate($reglas, $mensajes);
            
          
            $acronym = $this->obtenerTresLetras($request->input('nueva-categoria'));
            
            $dataCreate = [
                'catalog_types_id' => $request->input('tipo-gasto'),
                'name' => $request->input('nueva-categoria'),
                'acronym' => $acronym,
                'status' => 'ACTIVE',
                'user_id' => auth()->id()
            ];
            
            Catalog::create($dataCreate);
            
            Session::flash('success', 'Categoría registrada correctamente.');
            
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            Session::flash('error', $mensaje);
            return redirect()->back()->withInput();
        }
    }
    
    function obtenerTresLetras($cadena) {
        // Dividir la cadena en palabras
        $palabras = explode(' ', $cadena);
        
        // Obtener el número de palabras
        $numPalabras = count($palabras);
        
        // Inicializar la variable para almacenar las letras
        $letras = '';
        
        // Caso 1: Si hay una sola palabra
        if ($numPalabras == 1) {
            // Obtener las tres primeras letras
            $letras = strtoupper(substr($palabras[0], 0, 3));
        }
        // Caso 2: Si hay dos palabras
        elseif ($numPalabras == 2) {
            // Obtener la primera letra de la primera palabra y las otras dos de la segunda palabra
            $letras = strtoupper(substr($palabras[0], 0, 1)) . strtoupper(substr($palabras[1], 0, 2));
        }
        // Caso 3: Si hay tres o más palabras
        else {
            // Obtener la primera letra de la primera palabra, la segunda de la segunda y la tercera de la tercera palabra
            $letras = strtoupper(substr($palabras[0], 0, 1)) . strtoupper(substr($palabras[1], 0, 1)) . strtoupper(substr($palabras[2], 0, 1));
        }
        
        return $letras;
    }

    
    
    public function crearProveedor(Request $request)
    {
        try {
            $reglas = [
                'campus_id' => ['required'],
                'tipo_identidad' => ['required'],
                'identidad' => ['required'],
                'nombre_comercial' => ['required'],
                'direccion' => ['nullable'],
                'email' => ['nullable','email'],
                'telefono' => ['nullable','numeric'],
                'estado' => ['required'],
            ];
            
            $mensajes = [
                'campo.required' => 'El campo es obligatorio.',
                'campo.email' => 'El campo es debe ser un email válido.',
                'campo.email' => 'El campo debe ser numérico',
            ];
            
            
            $request->validate($reglas, $mensajes);
            
            $dataCreate = [
                'campus_id' => $request->input('campus_id'),
                'tipo_identidad' => $request->input('tipo_identidad'),
                'identidad' => $request->input('identidad'),
                'nombre_comercial' => $request->input('nombre_comercial'),
                'direccion' => $request->input('direccion'),
                'email' => $request->input('email'),
                'telefono' => $request->input('telefono'),
                'estado' => $request->input('estado'),
                'user_id' => auth()->id()
            ];
            
            $existe = Proveedor::where('identidad',$request->input('identidad'))->first();
            
            //return $existe;
            
            if($existe)
            {
                $existe->update($dataCreate);
            }
            else
            {
                Proveedor::create($dataCreate);
            }
            
            return response()->json([
                'success' => true,
                'data' => $dataCreate // Aquí colocas tus datos si la operación fue exitosa
            ]);
                        
            //return response()->json($result);
            
            Session::flash('success', 'Proveedor registrado correctamente.');
            
        } catch (Exception $e) {
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage() // Aquí colocas tu mensaje de error
            ]);
                        
            
            $mensaje = $e->getMessage();
            Session::flash('error', $mensaje);
            return redirect()->back()->withInput();
        }
    }
    

}
