<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Cash\SaveEmpresaRequest;
use App\Models\Cash\Empresa;
use App\Models\Cash\Firma;
use App\Models\Cash\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Exception;

use Illuminate\Support\Facades\Session;


class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index()
    {
        //if (!session('menus')) {
          //  return to_route('dashboard');
        //};
        
        $empresa=[];
        $firma = [];
        $factura = [];
        $empresa = DB::selectOne('CALL get_cash_empresa_sp()');
        
        if($empresa)
        {
            $empresa_id = $empresa->id;
            
            $firma = DB::selectOne('CALL get_cash_firma_digital_sp(?)', [$empresa_id]);
            
            $factura = DB::selectOne('CALL get_cash_factura_sp(?)', [$empresa_id]);
        }
        

        return view('cash/empresa/index', [
            'empresa' => $empresa,
            'firma' => $firma,
            'factura' => $factura]);
    }
    
    public function uploadFirma(Request $request)
    {
        
        try {
            
            $validatedData = $request->validate([
                'firma' => 'required|file|max:10240',
                'fecha_expiracion' => 'required',
                'clave' => 'required',
            ]);
            
            Storage::deleteDirectory('signature');
        
            // Subir el archivo
            $uploadedFile = $request->file('firma');
            
            $originalFilename = $uploadedFile->getClientOriginalName();
            
            $path = $uploadedFile->storeAs('signature', $originalFilename);
    
            // Guardar el path en la base de datos
            
            $empresa = Empresa::first();
                
            if($empresa)
            {
                $dataCreate = [
                    'empresa_id' => $empresa->id,
                    'firma' => $path,
                    'fecha_expiracion' => $request->input('fecha_expiracion'),
                    'clave' => $request->input('clave'),
                    'user_id' => auth()->id()
                ];
                
                $firma = Firma::first();
                
                if($firma)
                {
                    $firma->update($dataCreate);
                }
                else
                {
                    Firma::create($dataCreate);
                }
            }
            else
            {
                Session::flash('error', 'Cargue los datos de la firma.');
    
                return redirect()->back()->with('error', 'Archivo subido correctamente.');
            }
    
            Session::flash('success', 'El formulario se ha registrado correctamente.');
    
            return redirect()->back()->with('success', 'Archivo subido correctamente.');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage().' Hubo un error al procesar el formulario. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }
    
    public function datosFactura(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'punto_emision' => 'required',
                'secuencial_inicial' => 'required',
                'logo_path' => 'nullable|file|max:10240',
                'mensaje' => 'nullable',
            ]);
            
            Storage::deleteDirectory('logo');
        
            // Subir el archivo
            $path = '';
            
            if($request->file('logo_path'))
            {
                $uploadedFile = $request->file('logo_path');
                
                $originalFilename = $uploadedFile->getClientOriginalName();
                
                $path = $uploadedFile->storeAs('public/logo', $originalFilename);
            }
                
    
            // Guardar el path en la base de datos
            
            $empresa = Empresa::first();
                
            if($empresa)
            {
                $dataCreate = [
                    'empresa_id' => $empresa->id,
                    'punto_emision' => $request->input('punto_emision'),
                    'secuencial_inicial' => $request->input('secuencial_inicial'),
                    'logo_path' => $path,
                    'mensaje' => $request->input('mensaje'),
                    'user_id' => auth()->id()
                ];
                
                $factura = Factura::first();
                
                if($factura)
                {
                    $factura->update($dataCreate);
                }
                else
                {
                    Factura::create($dataCreate);
                }
            }
            else
            {
                Session::flash('error', 'Cargue los datos de la factura.');
    
                return redirect()->back()->with('error', 'Archivo subido correctamente.');
            }
    
            Session::flash('success', 'El formulario se ha registrado correctamente.');
    
            return redirect()->back()->with('success', 'El formulario se ha registrado correctamente.');
            
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage().' Hubo un error al procesar el formulario. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }


    public function create()
    {
       
    }

    public function store(Request $request)
    {
        try {
            
            $validatedData = Validator::make(
                $request->all(),
                [
                    'ruc' => ['required'],
                    'razonSocial' => ['required'],
                    'nombreComercial' => ['required'],
                    'ciudad' => ['required'],
                    'telefono' => ['required'],
                    'direccion' => ['required'],
                    'numeroEstablecimiento' => ['required'],
                    'obligadoContabilidad' => ['required'],
                    'contribuyenteEspecial' => ['required'],
                    'tipoContribuyenteEspecial' => ['required'],
                    'exportador' => ['required'],
                    'agenteRetencion' => ['required'],
                ]
            );
    
            if ($validatedData && $validatedData->fails()) {
                return redirect()->back()->withErrors($validatedData)->withInput();
            }
    
    
            $dataCreate = [
                'ruc' => $request->input('ruc'),
                'razonSocial' => $request->input('razonSocial'),
                'nombreComercial' => $request->input('nombreComercial'),
                'ciudad' => $request->input('ciudad'),
                'telefono' => $request->input('telefono'),
                'direccion' => $request->input('direccion'),
                'numeroEstablecimiento' => $request->input('numeroEstablecimiento'),
                'obligadoContabilidad' => $request->input('obligadoContabilidad'),
                'contribuyenteEspecial' => $request->input('contribuyenteEspecial'),
                'tipoContribuyenteEspecial' => $request->input('tipoContribuyenteEspecial'),
                'exportador' => $request->input('exportador'),
                'agenteRetencion' => $request->input('agenteRetencion'),
                'user_id' => auth()->id()
            ];
            
            $empresa = Empresa::first();
            
            if($empresa)
            {
                $empresa->update($dataCreate);
            }
            else
            {
                Empresa::create($dataCreate);
            }
    
            Session::flash('success', 'El formulario se ha registrado correctamente.');
        
            // Redirige al índice de Empresas con un mensaje de éxito
            return redirect()->route('Empresa.index')->with('status', 'Campus created successfully!');
        } catch (\Exception $e) {
            Session::flash('error', 'Hubo un error al procesar el formulario. Por favor, inténtalo de nuevo.');
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
