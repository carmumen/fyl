<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Global\SaveCatalogRequest;
use App\Models\Global\CatalogType;
use App\Models\Global\Catalog;
use Illuminate\Http\Request;
use Exception;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $catalog = Catalog::from('global_catalogs AS C')
                            ->join('global_catalog_types as CT', 'C.catalog_types_id', '=', 'CT.id')
                            ->where('C.name', 'LIKE', '%' . $search . '%')
                            ->orwhere('CT.name', 'LIKE', '%' . $search . '%')
                            ->select('C.id',
                                    'C.catalog_types_id',
                                    'CT.name as catalog_type',
                                    'C.name',
                                    'C.acronym',
                                    'C.status')
                            ->groupby('C.id','C.catalog_types_id','CT.name','C.name','C.acronym','C.status')
                            ->orderBy('CT.name','asc')
                            ->orderBy('C.name', 'asc')
                            ->orderBy('C.acronym','asc')
                            ->orderBy('C.status','asc')
                            ->paginate(10);
        $catalog->appends(['search' => $search, 'pag' => $pag]);
        return view('catalogs/catalogs.index',['catalog' => $catalog, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        // return  [
        //     'catalog' => new Catalog,
        //     'catalogType' => CatalogType::orderBy('name','ASC')->pluck('name','id')
        // ];
        return view('catalogs/catalogs.create', [
            'catalog' => new Catalog,
            'catalogType' => CatalogType::orderBy('name','ASC')->pluck('name','id')
        ]);
    }


    public function store(SaveCatalogRequest $request)
    {
        Catalog::create($request->validated());
        
        return view('catalogs/catalogs.create', [
            'catalog' => new Catalog,
            'catalogType' => CatalogType::orderBy('name','ASC')->pluck('name','id')
        ]);

        return to_route('Catalogs.index')->with('status', 'Catalog create!');
    }

    public function show(Catalog $catalog)
    {
        return view('catalogs/catalogs.show',['catalog' => $catalog]);
    }

    public function edit( $id)
    {
        $catalog = Catalog::findOrFail($id);
        return view('catalogs/catalogs.edit',[
            'catalog' => $catalog,
            'catalogType' => CatalogType::orderBy('name','ASC')->pluck('name','id')
        ]);
    }

    public function update(SaveCatalogRequest $request, $id)
    {
        $catalog = Catalog::findOrFail($id);
        $catalog->update($request->validated());

        return to_route('Catalogs.index', $catalog)->with('status', 'Catalog updated!');
    }

    public function destroy( $id)
    {
        try {
            $catalog = Catalog::findOrFail($id);
            $catalog->delete();

            return to_route('Catalogs.index')->with('status',__('Catalog deleted!'));

        } catch (Exception $e) {
            return to_route('Catalogs.index')->with('errors','El Tipo Catálogo no puede ser eliminado.');
        }

    }

    public function findCatalogTypeId($id){
        return Catalog::where('catalog_types_id',$id)->get();
    }

}
