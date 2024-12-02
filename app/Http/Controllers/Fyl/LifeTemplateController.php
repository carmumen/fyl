<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveLifeTemplateRequest;
use App\Models\Fyl\LifeTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class LifeTemplateController extends Controller
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

        $lifeTemplate = LifeTemplate::where('activity', 'LIKE', '%' . $search . '%')
                        ->orderBy('order','asc')
                        ->paginate($pag);

        $lifeTemplate->appends(['search' => $search, 'pag' => $pag]);

        return view('fyl/lifeTemplate.index',['lifeTemplate' => $lifeTemplate, 'search' => $search, 'pag' => $pag]);
    }

    public function create()
    {
        return view('fyl/lifeTemplate/create', [
            'lifeTemplate' => new LifeTemplate]);
    }

    public function store(SaveLifeTemplateRequest $request)
    {
        LifeTemplate::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('LifeTemplate.index')->with('status','Life Template create!');
    }

    public function show(LifeTemplate $lifeTemplate)
    {

    }

    public function edit( $id)
    {
        $lifeTemplate = LifeTemplate::findOrFail($id);
        // return $lifeTemplate;
        return view('fyl/lifeTemplate/edit', ['lifeTemplate' => $lifeTemplate]);
    }

    public function update(SaveLifeTemplateRequest $request, $id)
    {
        // $canton = Canton::findOrFail($id);
        // $canton->update($request->validated());

        // return to_route('Cantons.index', $canton)->with('status', 'Canton updated!');
        $lifeTemplate = LifeTemplate::findOrFail($id);
        $lifeTemplate->update($request->validated());

        return to_route('LifeTemplate.index', $lifeTemplate)->with('status', 'Life Template updated!');
    }

    public function destroy( $id)
    {
        try {
            $lifeTemplate = LifeTemplate::findOrFail($id);
            $lifeTemplate->delete();

            return to_route('LifeTemplate.index')->with('status',__('Life Template deleted!'));

        } catch (Exception $e) {
            return to_route('LifeTemplate.index')->with('errors','El registro de la plantilla no puede ser eliminado.');
        }

    }


}
