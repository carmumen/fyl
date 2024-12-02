<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveClientsRequest;
use App\Models\Fyl\Clients;
use App\Models\Fyl\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Config;
use Exception;

class ClientsController extends Controller
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
        $search = $request->input('search');
        $pag = $request->input('pag') ?: 30;

        $clients = Clients::from('fyl_clients as C')
            ->select(
                'C.id',
                'C.CC_RUC',
                'C.names_razon_social',
                'C.address',
                'C.address',
                'C.email',
                'C.phone'
            )
            ->where('C.names_razon_social', 'LIKE', '%' . $search . '%')
            ->orderBy('C.names_razon_social', 'asc')
            ->paginate($pag);

        $clients->appends(['search' => $search, 'pag' => $pag]);

        return view('fyl/clients.index', ['clients' => $clients, 'search' => $search, 'pag' => $pag]);
    }

    // public function index()
    // {
    //     $clients = Clients::get();

    //     return view('fyl/clients/index',['Clients' => $clients]);
    // }

    public function create()
    {

        return view('fyl/clients/create', [
            'clients' => new Clients
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'CC_RUC' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('fyl_clients', 'CC_RUC')->where(function ($query) use ($request) {
                    return $query->where('CC_RUC', $request->input('CC_RUC'));
                }),
            ],
            'names_razon_social' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
        ]);

        if ($validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $tablaClient = [
            'CC_RUC' => $request->input('CC_RUC'),
            'names_razon_social' => $request->input('names_razon_social'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'user_id' => auth()->id()
        ];

        Clients::create($tablaClient);

      return to_route('Clients.index')->with('status', 'Clients create!');


    }
    // return to_route('Clients.create')->with('errors',$e->getMessage());
    public function show(Clients $clients)
    {
        return view('fyl/clients/show', ['Clients' => $clients]);
    }

    public function edit($id)
    {
        $clients = Clients::findOrFail($id);
        return view('fyl/clients/edit', [
            'clients' => $clients
        ]);
    }

    public function update(Request $request, $id)
    {
        $clients = Clients::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'CC_RUC' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('fyl_clients', 'CC_RUC')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('CC_RUC', $request->input('CC_RUC'));
                }),
            ],
            'names_razon_social' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
        ]);


        if ($validator && $validator->fails()) {
            // Si la validación falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tablaClient = [
            'CC_RUC' => $request->input('CC_RUC'),
            'names_razon_social' => $request->input('names_razon_social'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'user_id' => auth()->id()
        ];

        //$data = $request->except(['_token', '_method']);

        $clients->update($tablaClient);

        return to_route('Clients.index', $clients)->with('status', 'Clients updated!');
    }

    public function destroy($id)
    {
        try {
            $clients = Clients::findOrFail($id);
            $hasPayments = Payment::where('CC_RUC', $clients->CC_RUC)->exists();

            if ($hasPayments) {
                // Si existen pagos asociados al cliente, muestra un mensaje de error o realiza la acción que necesites
                return redirect()->back()->with('errors', 'No puedes eliminar este cliente porque tiene pagos registrados.');
            }
            //$clients = Clients::where('id', $id);
            $clients->delete();
        } catch (Exception $e) {
            return to_route('Clients.index')->with('errors', 'El Cliente no puede ser eliminado.');
        }

        return to_route('Clients.index')->with('status', __('Clients deleted!'));
    }
}
