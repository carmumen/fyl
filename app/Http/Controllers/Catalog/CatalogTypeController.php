<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Global\SaveCatalogTypeRequest;
use App\Models\Global\CatalogType;
use Illuminate\Http\Request;
use Exception;

class CatalogTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $pag = $request->input('pag') ? : 10;

        $catalogType = CatalogType::where('global_catalog_types.name', 'LIKE', '%' . $search . '%')
        ->paginate($pag);
        $catalogType->appends(['search' => $search, 'pag' => $pag]);
        return view('catalogs/catalogTypes.index',['catalogType' => $catalogType, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('catalogs/catalogTypes.create', [
            'catalogType' => new CatalogType
        ]);
    }


    public function store(SaveCatalogTypeRequest $request)
    {
        CatalogType::create($request->validated());

        return to_route('CatalogTypes.index')->with('status', 'CatalogType create!');
    }

    public function show(CatalogType $catalogType)
    {
        return view('catalogs/catalogTypes.show',['catalogType' => $catalogType]);
    }

    public function edit( $id)
    {
        $catalogType = CatalogType::findOrFail($id);
        return view('catalogs/catalogTypes.edit',[
            'catalogType' => $catalogType
        ]);
    }

    public function update(SaveCatalogTypeRequest $request, $id)
    {
        $catalogType = CatalogType::findOrFail($id);
        $catalogType->update($request->validated());

        return to_route('CatalogTypes.index', $catalogType)->with('status', 'CatalogType updated!');
    }

    public function destroy( $id)
    {
        try {
            $catalogType = CatalogType::findOrFail($id);
            $catalogType->delete();

            return to_route('CatalogTypes.index')->with('status',__('CatalogType deleted!'));

        } catch (Exception $e) {
            return to_route('CatalogTypes.index')->with('errors','El Tipo Catálogo no puede ser eliminado.');
        }

    }

}
