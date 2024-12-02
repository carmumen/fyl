<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Global\SaveCountryRequest;
use App\Models\Global\Country;
use Illuminate\Http\Request;
use Exception;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $country = Country::where('global_countries.name', 'LIKE', '%' . $search . '%')->paginate(10);
        $country->appends(['search' => $search, 'pag' => $pag]);
        return view('catalogs/countries.index',['country' => $country, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('catalogs/countries.create', [
            'country' => new Country
        ]);
    }


    public function store(SaveCountryRequest $request)
    {
        Country::create($request->validated());

        return to_route('Countries.index')->with('status', 'Country create!');
    }

    public function show(Country $country)
    {
        return view('catalogs/countries.show',['country' => $country]);
    }

    public function edit( $id)
    {
        $country = Country::findOrFail($id);
        return view('catalogs/countries.edit',[
            'country' => $country
        ]);
    }

    public function update(SaveCountryRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->validated());

        return to_route('Countries.index', $country)->with('status', 'Country updated!');
    }

    public function destroy( $id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();

            return to_route('Countries.index')->with('status',__('Country deleted!'));

        } catch (Exception $e) {
            return to_route('Countries.index')->with('errors','El País no puede ser eliminado.');
        }

    }

    public function findCountry($parametro){
        return Country::select( 'id',
                                'name as label')
                        ->where('name','LIKE', '%'.$parametro.'%')->get();
    }

}
