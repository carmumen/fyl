<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveCampusRequest;
use App\Models\Fyl\Campus;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class CampusController extends Controller
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

        $campus = Campus::from('fyl_campus as C')
                        ->join('global_cities as CI', 'C.city_id', '=', 'CI.id')
                        ->select('C.id',
                                 'C.name',
                                 'C.address',
                                 'C.phone',
                                 'C.facturacion',
                                 'C.botonPagos',
                                 'C.status',
                                 'CI.name as city')
                        ->where('C.name', 'LIKE', '%' . $search . '%')
                        ->orderBy('C.name','asc')
                        ->paginate($pag);

        $campus->appends(['search' => $search, 'pag' => $pag]);

        return view('fyl/campus.index',['campus' => $campus, 'search' => $search, 'pag' => $pag]);
    }
    
    private function validateCedulaEcuador($cedula)
    {
        if (strlen($cedula) !== 10) {
            return false;
        }

        $coeficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $result = $cedula[$i] * $coeficients[$i];
            $sum += $result > 9 ? $result - 9 : $result;
        }

        $calculatedLastDigit = ($sum % 10 === 0) ? 0 : 10 - ($sum % 10);
        $lastDigit = intval(substr($cedula, -1));

        return $lastDigit === $calculatedLastDigit;
    }
    
    public function validarCedulaEcuatoriana($cedula) {
        $cedula = str_replace([' ', '-'], '', $cedula);
        
        if (strlen($cedula) !== 10 || !is_numeric($cedula)) {
            return false;
        }
        
        $verificador = (int)substr($cedula, 9, 1);
        
        $suma = 0;
        for ($i = 0; $i < 9; $i++) {
            $valor = (int)$cedula[$i];
    
            if ($i % 2 === 0) {
                $valor *= 2;
    
                if ($valor > 9) {
                    $valor -= 9;
                }
            }
    
            $suma += $valor;
        }
        
        $digitoVerificador = 10 - ($suma % 10);
        
        if ($digitoVerificador === 10) {
            $digitoVerificador = 0;
        }
    
        return $digitoVerificador === $verificador;
    }


    public function create()
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

        return view('fyl/campus/create', [
            'city' => $city,
            'campus' => new Campus]);
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
        
        //return $Campus;

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
            'facturacion' => ['required'],
            'botonPagos' => ['required'],
            'status' => ['required'],
        ]);

        //return $validator;

        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);
        
        //return $data;

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
