<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Client\SaveClientRequest;
use App\Models\Global\Catalog;
use App\Models\Global\Country;
use App\Models\Global\Province;
use App\Models\Global\Canton;
use App\Models\Global\City;
use App\Models\Client\Client;
use Illuminate\Http\Request;
use Exception;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);

    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $clients = Client::from('client_clients AS C')
                            ->join('global_catalogs as G', 'G.id', '=', 'C.gender_catalog_id')
                            ->join('global_catalogs as CS', 'CS.id', '=', 'C.civil_status_catalog_id')
                            ->join('global_catalogs as EL', 'EL.id', '=', 'C.education_level_catalog_id')
                            ->where('C.names', 'LIKE', '%' . $search . '%')
                            ->orwhere('C.surnames', 'LIKE', '%' . $search . '%')
                            ->orwhere('C.email', 'LIKE', '%' . $search . '%')
                            ->orwhere('G.name', 'LIKE', '%' . $search . '%')
                            ->orwhere('CS.name', 'LIKE', '%' . $search . '%')
                            ->orwhere('EL.name', 'LIKE', '%' . $search . '%')
                            ->select('C.id',
                                    'C.DNI',
                                    'C.names',
                                    'C.surnames',
                                    'C.birthdate',
                                    'C.gender_catalog_id',
                                    'C.civil_status_catalog_id',
                                    'C.education_level_catalog_id',
                                    'C.address',
                                    'C.email',
                                    'C.status',
                                    'G.name as gender',
                                    'CS.name as civil_status',
                                    'EL.name as education_level')
                            ->groupby('C.id','C.DNI','C.names','C.surnames','C.birthdate','C.gender_catalog_id','C.civil_status_catalog_id',
                                      'C.education_level_catalog_id','C.address','C.email','C.status','G.name','CS.name','EL.name')
                            ->orderBy('C.surnames','asc')
                            ->orderBy('C.names', 'asc')
                            ->paginate($pag);
        $clients->appends(['search' => $search, 'pag' => $pag]);

        return view('client/clients/index',['client' => $clients, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('client/clients/create', [
            'client' => new Client,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
            'education_level' => Catalog::where('catalog_types_id',3)->pluck('name','id'),
            'cities' => new City,
            'cantons' => new Canton,
            'provinces' => new Province ,
            'countries' => Country::orderBy('name','ASC')->where('status','=','ACTIVO')->pluck('name','id')
        ]);
    }

    public function store(SaveClientRequest $request)
    {
        try {

            Client::create($request->validated());

            return to_route('Clients.index')->with('status','Client create!');

        } catch (Exception $e) {
            return to_route('Clients.index')->with('errors','Error. Imposible registrar, verifique que el cliente no se encuentre registrado.');
        }

    }

    public function show(Client $client)
    {
        return view('client/clients/show',['client' => $client]);
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('client/clients/edit',[
            'client' => $client,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
            'education_level' => Catalog::where('catalog_types_id',3)->pluck('name','id'),
            'cities' => City::orderBy('name','ASC')->where('province_id','=',$client['canton_id'])->pluck('name','id'),
            'cantons' => Canton::orderBy('name','ASC')->where('province_id','=',$client['province_id'])->pluck('name','id'),
            'provinces' => Province::orderBy('name','ASC')->where('country_id','=',$client['country_id'])->pluck('name','id'),
            'countries' => Country::orderBy('name','ASC')->where('status','=','ACTIVO')->pluck('name','id')
        ]);
    }

    public function update(SaveClientRequest $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->update($request->validated());

            return to_route('Clients.index', $client)->with('status','Client updated!');

        } catch (Exception $e) {
            return to_route('EmployeeOccupations.index')->with('errors','Error. Imposible actualizar, verifique que el cliente no se encuentre registrado.');
        }
    }

    public function destroy( $id)
    {
        try {
            
            $exists = DB::table('fyl_clients as C')
                        ->join('fyl_payment P', 'C.CC_RUC', '=', 'P.CC_RUC')
                        ->where(C.id,$id)->first();
               
            if($exists)
            {
               return to_route('Clients.index')->with('errors','Cliente no puede ser eliminado.'); 
            }
            
            $client = Client::findOrFail($id);
            $client->delete();

        } catch (Exception $e) {
            return to_route('Clients.index')->with('errors','Cliente no puede ser eliminado.');
        }
        return to_route('Clients.index')->with('status','Client deleted!');
    }


    public function findClient($parametro){
        return Client::from('client_clients AS E')
        ->select( 'E.id',
                  DB::raw("(CONCAT(E.surnames,' ',E.names)) as label"))
        ->where('surnames','LIKE', '%'.$parametro.'%')->get();
    }


}
