<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Global\SaveCityRequest;
use App\Models\Global\Country;
use App\Models\Global\Province;
use App\Models\Global\Canton;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Exception;

class CityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        //return $pag;

        $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'C.id', '=', 'CI.canton_id')
        ->join('global_provinces as P', 'P.id', '=', 'C.province_id')
        ->join('global_countries as CO', 'CO.id', '=', 'P.country_id')
        ->where('P.name', 'LIKE', '%' . $search . '%')
        ->orwhere('C.name', 'LIKE', '%' . $search . '%')
        ->orwhere('CO.name', 'LIKE', '%' . $search . '%')
        ->select('CI.id',
                'CI.canton_id',
                'CI.code',
                'CI.name',
                'CI.type_division',
                'CI.status',
                'CO.name as country',
                'P.name as province',
                'C.name as canton')
        ->groupby('CI.id','CI.canton_id','CI.code','CI.name','CI.type_division','CI.status','CO.name', 'P.name','C.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('C.name','asc')
        ->orderBy('CI.name','asc')
        ->paginate($pag);

        // Inicializar el contador
        $contador = ($city->currentPage() - 1) * $city->perPage() + 1;

        // Asignar el número secuencial a cada registro
        foreach ($city as $cityItem) {
            $cityItem->secuencial = $contador;
            $contador++;
        }

        $city->appends(['search' => $search, 'pag' => $pag]);

       //return $city;

        return view('catalogs/cities.index',['city' => $city, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('catalogs/cities.create', [
            'city' => new City,
            'cantons' => new Canton,
            'provinces' => new Province ,
            'countries' => Country::orderBy('name','ASC')->where('status','=','ACTIVO')->pluck('name','id')
        ]);
    }


    public function store(SaveCityRequest $request)
    {
        City::create($request->validated());

        return to_route('Cities.index')->with('status', 'City create!');
    }

    public function show(Province $city)
    {
        return view('catalogs/cities.show',['city' => $city]);
    }

    public function edit( $id)
    {
        $city = City::join('global_cantons as C', 'global_cities.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('global_cities.id',
                'global_cities.canton_id',
                'global_cities.code',
                'global_cities.name',
                'global_cities.type_division',
                'global_cities.status',
                'CO.id as country_id',
                'CO.name as country',
                'P.id as province_id',
                'P.name as province',
                'C.name as canton')
        ->findOrFail($id);

        return view('catalogs.cities.edit', [
            'city' => $city,
            'cantons' => Canton::orderBy('name','ASC')->where('province_id','=',$city['province_id'])->pluck('name','id'),
            'provinces' => Province::orderBy('name','ASC')->where('country_id','=',$city['country_id'])->pluck('name','id'),
            'countries' => Country::orderBy('name','ASC')->where('status','=','ACTIVO')->pluck('name','id'),
            'search' => $city['province']
        ]);
    }

    public function update(SaveCityRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $canton = Canton::findOrFail($city['canton_id']);
        $province = Province::findOrFail($canton['province_id']);
        $search = $province['name'];
        $city->update($request->validated());

        return to_route('Cities.index', ['city' => $city, 'search' => $search])->with('status', 'City updated!');
    }

    public function destroy( $id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();

            return to_route('Cities.index')->with('status',__('City deleted!'));

        } catch (Exception $e) {
            return to_route('Cities.index')->with('errors','La Ciudad no puede ser eliminada.');
        }

    }

    public function findCity($parametro){
        return City::select( 'id',
                                'name')
                        ->where('canton_id','=', $parametro)->get();
    }

}
