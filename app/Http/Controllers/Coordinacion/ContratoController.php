<?php

namespace App\Http\Controllers\Coordinacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\Coordinacion\Contrato;

use Exception;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;


class ContratoController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $userId = auth()->id();
                            
        $training = DB::table('fyl_life_participants as l')
                        ->select('l.training_id')
                        ->join('fyl_participants as p', 'l.participant_DNI', '=', 'p.DNI')
                        ->join('users as u', 'p.email', '=', 'u.email')
                        ->where('u.id', $userId)
                        ->orderBy('l.training_id', 'desc')
                        ->first();

        $contrato = Contrato::where('training_id', $training->training_id)
                            ->where('user_id', $userId)
                            ->get();
                            
                            //return $contrato;
        
        if ($contrato->count() == 0){
            return view('contrato/create',[
                        'contrato' => new Contrato
                    ]);
        }
        
        
        return view('contrato/index',[
                        'contrato' => $contrato,
                    ]);
    }
    
    public function create(Request $request)
    {
       return $request;
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contrato' => ['required'],
            'vision' => ['required'],
            'proposito' => ['required'],
        ]);

        if ($validator->fails()) {
            // Si la validaci贸n falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $userId = auth()->id();
        
        $participant = DB::table('fyl_participants as p')
                    ->join('users as u', 'p.email','=','u.email')
                    ->select('p.DNI')
                    ->where('u.id', $userId)->first();
        
        $training = DB::table('fyl_current_training_view')->where('user_id', $userId)->first();
        
        $tabla = [
            'participant_DNI' => $participant->DNI,
            'training_id' => $training->training_id_enroller,
            'contrato' => $request->input('contrato'),
            'vision' => $request->input('vision'),
            'proposito' => $request->input('proposito'),
            'user_id' => auth()->id(),
            'estado' => 'PENDIENTE APROBACIÓN'
        ];
        
        //return $tabla;

        Contrato::create($tabla);
        
        return to_route('contrato.index')->with('status', 'Registro creado!');
    }

    public function show()
    {
        
    }

    public function edit( $id)
    {
        $contrato = Contrato::where('id',$id)->first();
        
        if($contrato->estado == 'APROBADO')
        {
            $mensaje = 'El registro se encuentra aprobado y no puede ser modificado.';
            Session::flash('error', $mensaje);
            return redirect()->back()->withErrors($mensaje)->withInput();
        }
            
        
        return view('contrato/edit',[
                        'contrato' => $contrato,
                    ]);
    }
    
    public function update(SaveContratoRequest $request, Contrato $contrato)
    {
        $contrato->update($request->validated());
    
        return to_route('contrato.index')->with('status', 'Registro actualizado!');
    }


    public function destroy(Contrato $Contrato)
    {
        
    }


}
