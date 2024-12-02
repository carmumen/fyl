<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Global\SaveCantonRequest;
use App\Models\Global\Country;
use App\Models\Global\Province;
use App\Models\Global\Canton;
use Illuminate\Http\Request;
use Exception;

class CantonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $canton = Canton::from('global_cantons as C')
        ->join('global_provinces as P', 'P.id', '=', 'C.province_id')
        ->join('global_countries as CO', 'CO.id', '=', 'P.country_id')
        ->where('P.name', 'LIKE', '%' . $search . '%')
        ->orwhere('CO.name', 'LIKE', '%' . $search . '%')
        ->orwhere('C.name', 'LIKE', '%' . $search . '%')
        ->select('C.id',
                'C.province_id',
                'C.code',
                'C.name',
                'C.status',
                'CO.name as country',
                'P.name as province')
        ->groupby('C.id','C.province_id','C.code','C.name','C.status', 'CO.name', 'P.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('C.name','asc')
        ->paginate(10);
        $canton->appends(['search' => $search, 'pag' => $pag]);
        return view('catalogs/cantons.index',['canton' => $canton, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('catalogs/cantons.create', [
            'canton' => new Canton,
            'countries' => Country::orderBy('name','ASC')->where('status','=','ACTIVO')->pluck('name','id'),
            'provinces' => new Canton //Province::orderBy('name','ASC')->pluck('name','id')
        ]);
    }


    public function store(SaveCantonRequest $request)
    {
        Canton::create($request->validated());

        return to_route('Cantons.index')->with('status', 'Canton create!');
    }

    public function show(Province $canton)
    {
        return view('catalogs/cantons.show',['canton' => $canton]);
    }

    public function edit( $id)
    {
        $canton = Canton::join('global_provinces as P', 'global_cantons.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('global_cantons.id',
                'global_cantons.province_id',
                'global_cantons.code',
                'global_cantons.name',
                'global_cantons.status',
                'CO.id as country_id',
                'CO.name as country')
        ->findOrFail($id);

        return view('catalogs.cantons.edit', [
            'canton' => $canton,
            'provinces' => Province::orderBy('name','ASC')->where('country_id','=',$canton['country_id'])->pluck('name','id'),
            'countries' => Country::orderBy('name','ASC')->where('status','=','ACTIVO')->pluck('name','id')
        ]);
    }

    public function update(SaveCantonRequest $request, $id)
    {
        $canton = Canton::findOrFail($id);
        $canton->update($request->validated());

        return to_route('Cantons.index', $canton)->with('status', 'Canton updated!');
    }

    public function destroy( $id)
    {
        try {
            $canton = Canton::findOrFail($id);
            $canton->delete();

            return to_route('Cantons.index')->with('status',__('Canton deleted!'));

        } catch (Exception $e) {
            return to_route('Cantons.index')->with('errors','El Cantón no puede ser eliminado.');
        }

    }

    public function findCanton($parametro){
        return Canton::select( 'id',
                                'name')
                        ->where('province_id','=', $parametro)->get();
    }

}
