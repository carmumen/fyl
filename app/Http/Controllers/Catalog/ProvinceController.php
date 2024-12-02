<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Global\SaveProvinceRequest;
use App\Models\Global\Country;
use App\Models\Global\Province;
use Illuminate\Http\Request;
use Exception;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $province = Province::from('global_provinces as P')
        ->join('global_countries as C', 'P.country_id', '=', 'C.id')
        ->where('P.name', 'LIKE', '%' . $search . '%')
        ->orwhere('C.name', 'LIKE', '%' . $search . '%')
        ->select('P.id',
                'P.country_id',
                'P.code',
                'P.name',
                'P.code_RDEP',
                'P.code_MAP',
                'P.acronym',
                'P.status',
                'C.name as country')
        ->groupby('P.id','P.country_id','P.code','P.name', 'P.code_RDEP', 'P.code_MAP','P.acronym','P.status','C.name')
        ->orderBy('C.name','asc')
        ->orderBy('P.name','asc')
        ->paginate($pag);
        $province->appends(['search' => $search, 'pag' => $pag]);
        return view('catalogs/provinces.index',['province' => $province, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('catalogs/provinces.create', [
            'province' => new Province
        ]);
    }


    public function store(SaveProvinceRequest $request)
    {
        Province::create($request->validated());

        return to_route('Provinces.index')->with('status', 'Province create!');
    }

    public function show(Province $province)
    {
        return view('catalogs/provinces.show',['province' => $province]);
    }

    public function edit( $id)
    {

        $province = Province::join('global_countries as C', 'global_provinces.country_id', '=', 'C.id')
        ->select('global_provinces.id',
                'global_provinces.country_id',
                'global_provinces.code',
                'global_provinces.name',
                'global_provinces.code_RDEP',
                'global_provinces.code_MAP',
                'global_provinces.acronym',
                'global_provinces.status',
                'C.name as country')
        ->findOrFail($id);


       //$province = Province::findOrFail($id);
        return view('catalogs/provinces.edit',[
            'province' => $province
        ]);
    }

    public function update(SaveProvinceRequest $request, $id)
    {
        $province = Province::findOrFail($id);
        $province->update($request->validated());

        return to_route('Provinces.index', $province)->with('status', 'Province updated!');
    }

    public function destroy( $id)
    {
        try {
            $province = Province::findOrFail($id);
            $province->delete();

            return to_route('Provinces.index')->with('status',__('Province deleted!'));

        } catch (Exception $e) {
            return to_route('Provinces.index')->with('errors','La Provincia no puede ser eliminada.');
        }

    }

    public function findProvince($parametro){
        return Province::select( 'id',
                                'name')
                        ->where('country_id','=', $parametro)->get();
    }


}
