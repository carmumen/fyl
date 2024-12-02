<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SavePricesRequest;
use App\Models\Fyl\Prices;
use App\Models\Fyl\Campus;
use App\Models\Fyl\Programs;
use App\Models\Global\Catalog;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class PricesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $userId = auth()->id();
        
        $campus_user = DB::table('fyl_campus_user')
                ->where('user_id', $userId)
                ->pluck('campus_id')
                ->toArray();
                
               // return $campus_user;
        
        $search = $request->input('search');
        $page = $request->input('page') ?: 1;
        
        $pag = $request->input('pag') ?: 30;

        $prices = DB::table('fyl_prices as P')
                        ->join('fyl_campus as C', 'P.campus_id', '=', 'C.id')
                        ->join('fyl_programs as PR', 'P.program_id', '=', 'PR.id')
                        ->join('global_catalogs as CA', 'P.catalogo_id_currency', '=', 'CA.id')
                        ->join('global_catalogs as CA1', 'P.catalogo_id_price_type', '=', 'CA1.id')
                        ->select(
                            'P.id',
                            'P.description',
                            'P.programs_included',
                            'P.price',
                            'P.id_contifico',
                            'P.pvp_contifico',
                            'P.status',
                            'C.name as campus',
                            'PR.name as program',
                            'PR.level',
                            'CA.name as currency',
                            'CA1.name as price_type'
                        )
                        ->whereIn('P.campus_id', $campus_user)
                        ->where(function($query) use ($search) {
                            $query->where('C.name', 'LIKE', '%' . $search . '%')
                                  ->orWhere('PR.name', 'LIKE', '%' . $search . '%')
                                  ->orWhere('CA1.name', 'LIKE', '%' . $search . '%');
                        })
                        ->orderBy('C.name', 'asc')
                        ->orderBy('PR.level', 'asc')
                        ->orderBy('CA1.name', 'asc')
                        ->orderBy('P.description', 'asc')
                        ->orderBy('P.price', 'desc')
                        ->paginate($pag);


        $prices->appends(['search' => $search, 'pag' => $pag]);
    
    //return $prices;

        return view('fyl/prices.index', ['prices' => $prices, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        $campus = Campus::from('fyl_campus as C')
            ->orderBy('C.name', 'asc')->pluck('name', 'id');

        $programs = Programs::from('fyl_programs as P')
            ->orderBy('P.name', 'asc')->pluck('name', 'id');
            
        $contifico = DB::table('cash_productos')->pluck('nombre','id');

        return view('fyl/prices/create', [
            'campus' => $campus,
            'programs' => $programs,
            'currency' => Catalog::where('catalog_types_id', 9)->pluck('name', 'id'),
            'price_type' => Catalog::where('catalog_types_id', 12)->pluck('name', 'id'),
            'price' => new Prices,
            'contifico' => $contifico,
        ]);
    }

    public function store(SavePricesRequest $request)
    {
        if($request->campus_id == 2)
        {
            $request->id_contifico = '';
            $request->pvp_contifico = '';
        }
            
        Prices::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Prices.index')->with('status', 'Price create!');
    }

    public function show(Prices $prices)
    {
        return view('fyl/prices/show', ['price' => $prices]);
    }

    public function edit($id)
    {
        $prices = Prices::findOrFail($id);

        $campus = Campus::from('fyl_campus as C')
            ->select(
                'C.id',
                'C.name'
            )
            ->orderBy('C.name', 'asc')->pluck('name', 'id');

        $program = Programs::from('fyl_programs as P')
            ->select('P.id', 'P.name')
            ->orderBy('P.name', 'asc')
            ->get();

        $programs = $program->pluck('name', 'id')->toArray();
        
        $contifico = DB::table('cash_productos')->pluck('nombre','id');

        return view('fyl/prices/edit', [
            'campus' => $campus,
            'prices' => $prices,
            'programs' => $programs,
            'currency' => Catalog::where('catalog_types_id', 9)->pluck('name', 'id'),
            'price_type' => Catalog::where('catalog_types_id', 12)->pluck('name', 'id'),
            'contifico' => $contifico,
        ]);
    }

    public function update(SavePricesRequest $request, $id)
    {
        if($request->campus_id == 2)
        {
            $request->id_contifico = '';
            $request->pvp_contifico = '';
        }
            
        $prices = Prices::findOrFail($id);

        $prices->update($request->validated());

        return to_route('Prices.index', $prices)->with('status', 'Price updated!');
    }

    public function destroy($id)
    {
        try {
            $prices = Prices::findOrFail($id);
            $prices->delete();
            return to_route('Prices.index')->with('status', __('Price deleted!'));
        } catch (Exception $e) {
            return to_route('Prices.index')->with('errors', 'El precio no puede ser eliminado.');
        }
    }

    public function findProgram($campus,$program,$type)
    {
        return Prices::from('fyl_prices as P')
            ->join('global_catalogs as CA', 'P.catalogo_id_currency', '=', 'CA.id')
            ->join('global_catalogs as PT', 'P.catalogo_id_price_type', '=', 'PT.id')
            ->select(
                DB::raw("(CONCAT(P.price, '|', P.programs_included)) as price"),
                // 'P.price',
                // 'P.programs_included',
                DB::raw("(CONCAT(CA.acronym, ' ', price, ' ', description)) as name")
            )
            ->where('P.campus_id', $campus)
            ->where('P.program_id', $program)
            ->where('P.catalogo_id_price_type', $type)
            ->where('P.status', 'ACTIVE')
            ->orderby('P.price', 'DESC')->get();
    }
}
