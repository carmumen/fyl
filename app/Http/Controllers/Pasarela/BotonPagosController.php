<?php

namespace App\Http\Controllers\Pasarela;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Fyl\SaveCampusRequest;
use App\Models\Fyl\Campus;
use App\Models\Pasarela\PagoMedios;
use App\Models\Global\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Config;
use Exception;

class BotonPagosController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth', ['except' => ['index','show','pagomediosCobros']]);
    }
    
    

    public function index(Request $request)
    {
        /*
        
        "url": "https://payurl.link/C4S3rQ2730001806137",
        "token": "cha_Zn5woBxySym3becyJ70V1273"
 */
 
 $opcion = 1;
 
 if($opcion == 1)
{
 
        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer 3wv1x3b0eyc5zj8vxnqaiqaeiutgi7pphk4p0nbtrekg-gcpdrzsnlxihqhxgb7vszqlo',
            ])->get('https://api.abitmedia.cloud/pagomedios/v2/payment-requests?uuid=cha_Ppiw2cgyBvbBBmvje3gR8642');
            	
                     https://api.abitmedia.cloud/pagomedios/v2/payment-requests
            
        
        //$data = $response->json();
        //return $data;
        
        $data = $response->json();

// Verificar si el campo 'data' existe y si contiene elementos
if (isset($data['data']) && count($data['data']) > 0) {
    // Obtener el primer objeto del array 'data'
    $primerObjeto = $data['data'][0];
    
    // Seleccionar las claves necesarias
    $clavesNecesarias = [
        'id',
        'status',
        'reference',
        'description',
        'amount',
        'amount_with_tax',
        'amount_without_tax',
        'tax_value',
        'type',
        'source',
        'livemode',
        'card_brand',
        'currency',
        'response_code',
        'auth_code',
        'card_type',
        'acquirer_code',
        'acquirer_response',
        'batch',
        'cardholder',
        'display_number',
        'bin',
        'last_4_digits',
        'expiry_month',
        'expiry_year',
        'credit_type',
        'installments',
        'interest',
        'merchant_transaction_id',
        'third_party_name',
        'third_party_document',
        'third_party_phones',
    ];
    
    // Filtrar el objeto para incluir solo las claves necesarias
    $objetoFiltrado = array_intersect_key($primerObjeto, array_flip($clavesNecesarias));
    
    // Convertir el objeto filtrado a JSON
    $jsonResultado = json_encode($objetoFiltrado);
    
    // Ahora $jsonResultado contiene un objeto JSON con las claves seleccionadas
    return $jsonResultado;
}
}

 if($opcion == 2)
{

        $data = [
            "integration" => true,
            "third" => [
                "document" => "0915779748",
                "document_type" => "05",
                "name" => "Carlos Munoz",
                "email" => "cemm473@gmail.com",
                "phones" => "0987107353",
                "address" => "Iquique",
                "type" => "Individual"
            ],
            "generate_invoice" => 0,
            "description" => "Pago de prueba",
            "amount" => 1.15,
            "amount_with_tax" => 1.0,
            "amount_without_tax" => 0.0,
            "tax_value" => 0.15,
            "settings" => [],
            "notify_url" => 'https://www.focusyourlife.org/pagomedios/',
            "custom_value" => null,
            "has_cash" => 0,
            "has_cards" => 1
        ];

        
        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer 3wv1x3b0eyc5zj8vxnqaiqaeiutgi7pphk4p0nbtrekg-gcpdrzsnlxihqhxgb7vszqlo',
            ])->post('https://api.abitmedia.cloud/pagomedios/v2/payment-requests', $data);
            
           
        if($response){
            $dataResponse = [
                    'url' => $response['data']['url'],
                    'id' => $response['data']['token']
                ];
                
            PagoMedios::create($dataResponse);
                
                //return $dataResponse;
        }
        
        return $response->json();
}      
        
        
        
        /*
        
        //function request ($entityId, $items , $total, $valoriva, $base12, $base0, $email, $primer_nombre, $segundo_nombre, $apellido,
        //$cedula, $trx, $ip_address, $telefono, $direccion_cliente, $pais_cliente, $direccion_entrega, $pais_entrega,
        //$postcode){
        
            $entityId, 
            $items , 
            $total, 
            $valoriva, 
            $base12, 
            $base0, 
            $email, 
            $primer_nombre, 
            $segundo_nombre, 
            $apellido,
            $cedula, 
            $trx, 
            $ip_address, 
            $telefono, 
            $direccion_cliente, 
            $pais_cliente, 
            $direccion_entrega, 
            $pais_entrega,
            $postcode
        
            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=" .$entityId.
            "&amount=".$total.
            "&currency=USD".
            "&paymentType=DB".
            "&customer.givenName=".$primer_nombre
            "&customer.middleName=".$segundo_nombre.
            "&customer.surname=".$apellido.
            "&customer.ip=".$ip_address. //IP del cliente, no del servidor
            "&customer.merchantCustomerId=000000000001" //id de cada usuario en la plataforma
            "&merchantTransactionId=transaction_" .$trx. //ejemplo de identificador
            "&customer.email=" .$email.
            "&customer.identificationDocType=IDCARD".
            "&customer.identificationDocId=".$cedula. //10 caracteres m¨¢ximo
            "&customer.phone=".$telefono.
            "&billing.street1=".$direccion_cliente.
            "&billing.country=".$pais_cliente.
            "&billing.postcode".$postcode.
            "&shipping.street1=".$direccion_entrega.
            "&shipping.country=".$pais_entrega.
            "&risk.parameters[SHOPPER_MID]=1000000505".
            "&customParameters[SHOPPER_TID]=PD100406".
            "&customParameters[SHOPPER_ECI]=0103910".
            "&customParameters[SHOPPER_PSERV]=17913101".
            "&customParameters[SHOPPER_VAL_BASE0]=.$base0".
            "&customParameters[SHOPPER_VAL_BASEIMP]=.$base12".
            "&customParameters[SHOPPER_VAL_IVA]=.$valoriva";
        $i = 0;
        foreach($items["cart"] as $c){
            $data.= "&cart.items[".$i."].name=".$c["product_name"];
            $data.= "&cart.items[".$i."].description="."Descripcion: ".$c["product_name"];
            $data.= "&cart.items[".$i."].price=".$c["product_price"];
            $data.= "&cart.items[".$i."].quantity=".$c["q"];
            $i++:
        }
        $data .="&customParameters[SHOPPER_VERSIONDF]=2";
        $data .="&testMode=EXTERNAL";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)){
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
        }
        */
        
        /*
        //function request(){
            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=8a829418533cf31d01533d06f2ee06fa" .
                    "&amount=92.00" .
                    "&paymentType=DB";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGE4Mjk0MTg1MzNjZjMxZDAxNTMzZDA2ZmQwNDA3NDh8WHQ3RjIyUUVOWA=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)){
                return curl_error($ch);
            }
            curl_close($ch);
            
            $data = json_decode($responseData, true);
            
            return view('pasarela/payment.index',['responseDataFast' => $data]);
            //return $responseData;
        //}

       $data = [
                "integration" => true,
                "generate_invoice" => 0,
                "description" => "Link de prueba",
                "amount" => 1.08,
                "amount_with_tax" => 0.5,
                "amount_without_tax" => 0.5,
                "tax_value" => 0.08,
                "settings" => []
            ];
        
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Token' => '3wv1x3b0eyc5zj8vxnqaiqaeiutgi7pphk4p0nbtrekg-gcpdrzsnlxihqhxgb7vszqlo'
            ])->post('https://api.abitmedia.cloud/pagomedios/v2/payment-links', $data);
        
            // Manejar la respuesta
            return $response->json();


        return view('pasarela/payment.index');
        
        */
    }
    
    public function notificacionPago(Request $request)
    {
        // Aqu¨ª puedes manejar la notificaci¨®n
        
        // Por ejemplo, puedes acceder a los par¨¢metros recibidos en el request
        $status = $request->input('status');
        $reference = $request->input('reference');
        $authorizationCode = $request->input('authorizationCode');
        $cardBrand = $request->input('cardBrand');
        $cardNumber = $request->input('cardNumber');
        $expiryMonth = $request->input('expiryMonth');
        $expiryYear = $request->input('expiryYear');
        $customValue = $request->input('customValue');

        // Realiza las acciones necesarias con estos datos
        
        // Por ejemplo, puedes devolver una respuesta
        return response()->json(['message' => 'Notificaci¨®n recibida correctamente']);
    }
    
    
    public function pagomediosCobros(Request $request)
    {
        return view('fyl/life/PagoRecibido');
        // Obt¨¦n todos los datos del request
        $requestData = $request->all();
    
        // Guarda los datos en la base de datos
        PagoMedios::create([
            'request_data' => $requestData
        ]);
        
        
    
        // Puedes devolver una respuesta adecuada, por ejemplo:
        return response()->json(['message' => 'Datos guardados correctamente']);    
    }
    
    public function datafast(Request $request)
    {
       //return $request;
        
        $url = "https://test.oppwa.com/v1/checkout/".$request->id."/payment";
        $url .="?entityId=".$request->id;
        //$url .="?entityId=8a829418533cf31d01533d06f2ee06fa";
        $ch= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTg1MzNjZjMxZDAxNTMzZDA2ZmQwNDA3NDh8WHQ3RjIyUUVOWA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)){
            return curl_error($ch);
        }
        curl_close($ch);
        
        $data = json_decode($responseData, true);
            
            return view('pasarela/payment.index',['responseDataFast' => $data]);
        //return $responseData;
    }



    public function create()
    {
        $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('CI.id',
                  DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
                  )
        ->groupby('CI.id','CO.name', 'P.name','CI.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('CI.name','asc')->pluck('name','id');

        return view('fyl/campus/create', [
            'city' => $city,
            'campus' => new Campus]);
    }

    public function store(SaveCampusRequest $request)
    {
        Campus::create($request->validated() + ['user_id' => auth()->id()]);

        return to_route('Campus.index')->with('status','Campus create!');
    }

    public function show(Campus $Campus)
    {
        return view('fyl/campus/show',['Campus' => $Campus]);
    }

    public function edit(Campus $Campus)
    {
        $city = City::from('global_cities as CI')
        ->join('global_cantons as C', 'CI.canton_id', '=', 'C.id')
        ->join('global_provinces as P', 'C.province_id', '=', 'P.id')
        ->join('global_countries as CO', 'P.country_id', '=', 'CO.id')
        ->select('CI.id',
                  DB::raw("CONCAT(P.name,' - ',CI.name,' - (',CO.name,')')  as name")
                  )
        ->groupby('CI.id','CO.name', 'P.name','CI.name')
        ->orderBy('CO.name','asc')
        ->orderBy('P.name','asc')
        ->orderBy('CI.name','asc')->pluck('name','id');

        return view('fyl/campus/edit', [
            'city' => $city,
            'campus' => $Campus]);


        //return view('fyl/campus/edit',['Campus' => $Campus]);
    }

    public function update(Request $request, $id)
    {
        //return $request;
        $campus = Campus::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'city_id' => ['required'],
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'status' => ['required'],
        ]);

        //return $validator;

        if ($validator && $validator->fails()) {
            // Si la validaciÃ³n falla, redirige o muestra los errores
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method']);

        $campus->update($data);

        return to_route('Campus.index', $campus)->with('status','Campus updated!');
    }

    public function destroy(Campus $Campus)
    {
        try {
            $Campus->delete();
        } catch (Exception $e) {
            return to_route('Campus.index')->with('errors','La Sede no puede ser eliminada.');
        }

        return to_route('Campus.index')->with('status',__('Campus deleted!'));
    }


}
