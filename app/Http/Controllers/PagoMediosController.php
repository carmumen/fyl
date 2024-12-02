<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Pasarela\PagoMedios;
use App\Models\Fyl\Clients;

class PagoMediosController extends Controller
{
    public function metodo(Request $request)
    {
        // Accede a los datos enviados por POST
        $datos = $request->all();
        
        //return $datos;
        
        // Accede a los datos enviados por POST
        if ($datos) {
            if ($datos['status'] == "1") { 
                $valor = $datos['customValue'];
                
                $partes = explode('|', $valor);
                
                $uuid = $partes[0]; 
                $catalogo_id_price_type = $partes[1];
                
                if ($uuid) {
                    
                    $pagoMedios = PagoMedios::where('uuid', $uuid)->first();
                    
                    if ($pagoMedios) {
                        $data = $request->except(['customValue']);
                        
                        $pagoMedios->update($data);
                        
                        $dataExtra = $this->actualizaPago($pagoMedios->uuid);
                        
                        $pagoMedios->update($dataExtra);
                        
                        $datosPago =[
                            'DNI' => $pagoMedios->participant_DNI,
                            'token'=> $pagoMedios->token,
                            'catalogo_id_price_type' => $catalogo_id_price_type,
                            ];
                            
                        $this->payment_register($datosPago);
                        
                    } else {
                        // Maneja el caso en que no se encuentre ningÃºn pagoMedios con el UUID y el participant_DNI especificados
                    }
                } else {
                    // Maneja el caso en que customValue no contiene al menos dos valores separados por |
                }
                
                
            }
        }
        
        return view('fyl/life/PagoRecibido');
        
        return $datos;

        // Procesa los datos como desees

        // Retorna una respuesta si es necesario
        return response()->json(['mensaje' => 'Datos recibidos correctamente'], 200);
    }
    
    public function actualizaPago($uuid)
    {
        //return $uuid;
        $pagoMedios = PagoMedios::where('uuid', $uuid)->first();
        
        //return $pagoMedios;
        
        $participant = DB::table('fyl_participants')->where('DNI',$pagoMedios->participant_DNI)->first();
        
        $campus = DB::table('fyl_training')->where('id',$participant->training_id)->first();
        
        $pasarela = DB::table('pasarela_boton')->where('campus_id',$campus->campus_id)->first();
        
            
        $response = Http::withHeaders([
                    'Accept' => $pasarela->accept,
                    'Content-Type' => $pasarela->content_type,
                    'Authorization' => $pasarela->authorization,
                ])->get($pagoMedios->url_consulta);
     
        $data = $response->json();
        
        
        //return $data;
        
        
        $payment_id = '';
        $installments = '';
        $acquirer = '';
        $interest = '';
        $transmitter = '';
        $token = '';
        
        if (isset($data['data']) && count($data['data']) > 0) {
            // Iterar sobre cada elemento en la matriz 'data'
            foreach ($data['data'] as $elemento) {
                // Verificar si existe la clave 'transactions' en el elemento actual y si contiene elementos
                if (isset($elemento['transactions']) && count($elemento['transactions']) > 0) {
                    // Iterar sobre cada transacciÃ³n en la matriz 'transactions'
                    foreach ($elemento['transactions'] as $transaccion) {
                        // Acceder a los datos de la transacciÃ³n
                        $payment_id = $transaccion['payment_id'];
                        $installments = $transaccion['installments'];
                        $acquirer = $transaccion['acquirer'];
                        $interest = $transaccion['interest'];
                        $transmitter = $transaccion['transmitter'];
                    }
                }
            }
        }
        
    
        // Verificar si el campo 'data' existe y si contiene elementos
        if (isset($data['data']) && count($data['data']) > 0) {
            // Obtener el primer objeto del array 'data'
            $primerObjeto = $data['data'][0];
            // Seleccionar las claves necesarias
            $clavesNecesarias = [
                'description',
                'amount',
                'amount_with_tax',
                'amount_without_tax',
                'tax_value',
                'type',
                'source',
                'livemode',
                'currency',
                'response_code',
                'auth_code',
                'card_type',
                'acquirer_code',
                'acquirer_response',
                'batch',
                'display_number',
                'bin',
                'last_4_digits',
                'credit_type',
                'installments',
                'interest',
                'merchant_transaction_id',
                'third_party_name',
                'third_party_document',
                'third_party_phones',
            ];
            
            $datosTransaccion = [
                'payment_id' => $payment_id,
                'installments' => $installments,
                'interest' => $interest,
                'transmitter' => $transmitter,
                'acquirer' => $acquirer,
            ];
            
            
            
            // Filtrar el objeto para incluir solo las claves necesarias
            $objetoFiltrado = array_intersect_key($primerObjeto, array_flip($clavesNecesarias));
            
            return $objetoFiltrado = array_merge($objetoFiltrado, $datosTransaccion);
            
        }
    }
    
    
    public function payment_register($datos)
    {
        
        $retorno = false;
        
        $participant = DB::table('fyl_participants')->where('DNI',$datos['DNI'])->first();
        
        //return $participant;
        
        $pagoMedios = DB::table('pago_medios')->where('token',$datos['token'])->first();
        
        $programs_included = 'F';
        
        $payment_date = substr($pagoMedios->transactionDate, 0, 10);
        $price_type = $datos['catalogo_id_price_type'];
        
        $catalog_id_payment_method = 12;
        $catalog_id_card = $this->transmitter($pagoMedios->transmitter);
        $catalog_id_tipo_pago = $this->credit_type($pagoMedios->credit_type);
        $catalog_id_bank = 191;
        
        $authorization_number = $pagoMedios->auth_code;
        
        $catalog_id_payment_record = 51;
        
        $amount = $pagoMedios->amount;
        
        $CC_RUC = ($participant->fac_DNI !== null) ? $participant->fac_DNI : $participant->DNI;
        $names_razon_social = ($participant->fac_razon_social !== null) ? $participant->fac_razon_social : $participant->surnames_names;
        $email = ($participant->fac_email !== null) ? $participant->fac_email : $participant->email;
        $address = ($participant->fac_direccion !== null) ? $participant->fac_direccion : $participant->address;
        $phone = ($participant->fac_telefono !== null) ? $participant->fac_telefono : $participant->phone;

        $comment = 'Pago Medios';
        $auth_id = 9;
        
        $data = [
            $participant->training_id,
            $participant->DNI,
            $amount,
            $programs_included,
            $payment_date,
            $price_type,
            $catalog_id_payment_method,//revisor para debito
            $catalog_id_card,
            $catalog_id_tipo_pago,
            $catalog_id_bank,
            $authorization_number,
            $catalog_id_payment_record,
            $amount,
            $CC_RUC,
            $comment,
            $auth_id,
            
            ];
        
        //return $payment_date;
        //return $data;
        
            // Llamar al procedimiento almacenado
            $results = DB::select(
                'CALL fyl_insert_payments(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, @estado, @mensaje)',
                [
                    $participant->training_id,
                    $participant->DNI,
                    $amount,
                    $programs_included,
                    $payment_date,
                    $price_type,
                    $catalog_id_payment_method,//revisor para debito
                    $catalog_id_card,
                    $catalog_id_tipo_pago,
                    $catalog_id_bank,
                    $authorization_number,
                    $catalog_id_payment_record,
                    $amount,
                    $CC_RUC,
                    $comment,
                    $auth_id,
                ]
            );
            

            $tablaClient = [
                'CC_RUC' => $CC_RUC,
                'RUC' => $CC_RUC,
                'names_razon_social' => $names_razon_social,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'user_id' => $auth_id
            ];
            
            // $tablaClient;
            
            $clients = Clients::where('CC_RUC', $CC_RUC)->count();

            if ($clients !== 0) {
                $clients = Clients::where('CC_RUC', $CC_RUC)->first();
                $clients->update($tablaClient);
                $retorno = true;
            } else {
                Clients::create($tablaClient);
                $retorno = true;
            }
            
            return $retorno;

    }
    
    public function credit_type($valor)
    {
        $retorno = '0';
        
        switch ($valor) {
        case '00':
            $retorno = 23;
            break;
        case '01':
            $retorno = 22;
            break;
        case '02':
            $retorno = 53;
            break;
        case '03':
            $retorno = 54;
            break;
        case '04':
            $retorno = 55;
            break;
        case '05':
            $retorno = 56;
            break;
        case '06':
            $retorno = 57;
            break;
        case '09':
            $retorno = 58;
            break;
        case '10':
            $retorno = 59;
            break;
        case '12':
            $retorno = 60;
            break;
        case '18':
            $retorno = 61;
            break;
        case '24':
            $retorno = 62;
            break;
            
        default:
            $retorno = 0;
        }
        
        return $retorno;

    }
    
    
    
    public function transmitter($valor)
    {
        $retorno = '21'; // Valor por defecto
        
        // Utilizamos strpos para encontrar la posici¨®n de la subcadena buscada
        // y comparamos el resultado con !== false para verificar si se encontr¨® la subcadena
        switch (true) {
            case strpos($valor, 'VISA') !== false:
                $retorno = 17;
                break;
            case strpos($valor, 'MASTERCARD') !== false:
                $retorno = 18;
                break;
            case strpos($valor, 'DINERS') !== false:
                $retorno = 19;
                break;
            case strpos($valor, 'AMERICAN') !== false:
                $retorno = 20;
                break;
            case strpos($valor, 'DISCOVER') !== false:
                $retorno = 75;
                break;
            default:
                $retorno = 21; // Valor por defecto si no se encuentra ninguna coincidencia
        }
        
        return $retorno;
    }

    
    

}