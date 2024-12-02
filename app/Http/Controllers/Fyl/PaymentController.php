<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Fyl\Transferencia;
use App\Models\Fyl\Participants;
use App\Models\Users;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Exception;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function payment_edit($id)
    {
        try {
            
            $payment = DB::table('fyl_payment')
                ->join('fyl_clients', 'fyl_payment.CC_RUC', '=', 'fyl_clients.CC_RUC')
                ->select('fyl_payment.id as payment_id', 'fyl_clients.*')
                ->where('fyl_payment.id', $id)
                ->first();
        
            return view('fyl/participants/payment-edit', $payment); 
            
        } catch (Exception $e) {
            return to_route('Participants.index')->with('errors', 'El Pago no puede ser eliminado.' . $e->getMessage());
        }  
    }

    public function payment_transferencia(Request $request)
    {
        try {
            
            $pagos = DB::table('fyl_pagos_sin_utilizar')->get();
            
            $origen = [];
            $destino = [];
            
            $data = [
                'entrenamiento' => '',
                'pagos' => $pagos,
                'origen' => $origen,
                'destino' => $destino
                ];
                
            //return $data;
            
            return view('fyl/participants/transferencia', $data);
            
        } catch (Exception $e) {
            return to_route('Participants.index')->with('errors', 'El Pago no puede ser eliminado.' . $e->getMessage());
        }    
    }
    
    public function busca_transferencia(Request $request)
    {
        try {
            
            $pagos = DB::table('fyl_pagos_sin_utilizar')->get();
            
            $entrenamiento = $request->entrenamiento;
            
            $origen = [];
            $destino = [];
            
            switch  ($entrenamiento)
            {
                case 'FOCUS':
                    $origen = DB::table('fyl_no_asistieron_focus_view')->get();
                    $destino = DB::table('fyl_no_pago_focus_view')->get();
                    break;
                case 'YOUR':
                    $origen = DB::table('fyl_no_asistieron_your_view')->get();
                    $destino = DB::table('fyl_no_pago_your_view')->get();
                    break;
                case 'LIFE':
                    $origen = DB::table('fyl_no_asistieron_life_view')->get();
                    $destino = DB::table('fyl_no_pago_life_view')->get();
                    break;
            }
            
            $data = [
                'entrenamiento' => $entrenamiento,
                'pagos' => $pagos,
                'origen' => $origen,
                'destino' => $destino
                ];
                
            
                
            //return $data;
            
            //return $entrenamiento;
            
            return view('fyl/participants/transferencia', $data);
            
        } catch (Exception $e) {
            return to_route('Participants.index')->with('errors', 'El Pago no puede ser eliminado.' . $e->getMessage());
        }    
    }

    public function payment_transferir(Request $request)
    {
        try {
            
            //return $request;
            
            $validatedData = Validator::make(
                $request->all(),
                [
                    'entrenamiento' => ['required'],
                    'DNI_origen' => ['required'],
                    'DNI_destino' => ['required'],
                    'observacion' => ['required'],
                ]
            );


            if ($validatedData && $validatedData->fails()) {
                return redirect()->back()->withErrors($validatedData)->withInput();
            }
                
                
            $data = [
                'entrenamiento' => $request->input('entrenamiento'),
                'DNI_transfiere' => $request->input('DNI_origen'),
                'DNI_recibe' => $request->input('DNI_destino'),
                'comentario' => $request->input('observacion'),
                'user_id' => auth()->id(),
            ];
            
            $origen = Participants::where('DNI', $request->input('DNI_origen'))->first();
            
            $destino = Participants::where('DNI', $request->input('DNI_destino'))->first();
            
            if ($origen && $destino) {
                
                $transferencia = Transferencia::create($data);

                $transferenciaId = $transferencia->id;
                
                $pago_origen = null;
                $pago_destino = 'PAGO TOTAL';
            
                $entrenamiento = $request->input('entrenamiento'); // Asegúrate de obtener este valor
            
                switch ($entrenamiento) {
                    case 'FOCUS':
                        $origen->update(['payment_status_focus' => null, 'transferencia_id' => $transferenciaId]);
                        $destino->update(['payment_status_focus' => 'PAGO TOTAL']);
                        break;
                    case 'YOUR':
                        $origen->update(['payment_status_your' => null, 'transferencia_id' => $transferenciaId]);
                        $destino->update(['payment_status_your' => 'PAGO TOTAL']);
                        break;
                    case 'LIFE':
                        $origen->update(['payment_status_life' => null, 'transferencia_id' => $transferenciaId]);
                        $destino->update(['payment_status_life' => 'PAGO TOTAL']);
                        break;
                    default:
                        // Opcional: Manejo de caso si el entrenamiento no coincide
                        return response()->json(['error' => 'Entrenamiento no válido'], 400);
                }
                
                return to_route('PaymentT.transferencia')->with('success', 'Transferencia exitosa');
                
            } else {
                // Manejo de error si $origen o $destino son nulos
                return response()->json(['error' => 'Origen o destino no válidos'], 400);
            }
            
        } catch (Exception $e) {
            return to_route('PaymentT.transferencia')->with('errors', $e->getMessage());
        }    
    }
}