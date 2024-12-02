<?php

namespace App\Http\Controllers\Contifico;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ContificoController extends Controller
{

    public function fetchData()
    {
        $client = new Client();
    
        $response = $client->post('https://api.contifico.com/sistema/api/v1/documento/', [
            'headers' => [
                //'user' => 'APIPRUEBA',
                //'password' => 'APIPRUEBA',
                'Authorization' => 'FrguR1kDpFHaXHLQwplZ2CwTX3p8p9XHVTnukL98V5U',
                'Api-Token' => 'dce704ae-189e-4545-bea3-257d9249a594',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "pos" => "dce704ae-189e-4545-bea3-257d9249a594", //"ceaa9097-1d76-4eb8-0000-6f412fa0297b",
                "fecha_emision" => "01/11/2016",
                "tipo_documento" => "FAC",
                "documento" => "001-001-000208091",
                "estado" => "P",
                "electronico" => true,
                "autorizacion" => "",
                "caja_id" => null,
                "cliente" => [
                    "ruc" => "0922054366001",
                    "cedula" => "0922054366",
                    "razon_social" => "Nombres del Cliente",
                    "telefonos" => "0988800001",
                    "direccion" => "Direccion cliente",
                    "tipo" => "N",
                    "email" => "cliente@contifico.com",
                    "es_extranjero" => false
                ],
                "vendedor" => [
                    "ruc" => "0904728680001",
                    "cedula" => "0904728680",
                    "razon_social" => "Nombres del Vendedor",
                    "telefonos" => "5104910",
                    "direccion" => "direccion del vendedor",
                    "tipo" => "N",
                    "email" => "vendedor@contifico.com",
                    "es_extranjero" => false
                ],
                "descripcion" => "FACTURA 8042",
                "subtotal_0" => 0.00,
                "subtotal_12" => 1.35,
                "iva" => 0.16,
                "ice" => 0.00,
                "servicio" => 0.00,
                "total" => 1.51,
                "adicional1" => "",
                "adicional2" => "",
                "detalles" => [
                    [
                        "producto_id" => "RZxg87rxLh9Mb1pV",
                        "cantidad" => 1.00,
                        "precio" => 1.00,
                        "porcentaje_iva" => 12,
                        "porcentaje_descuento" => 0.00,
                        "base_cero" => 0.00,
                        "base_gravable" => 1.00,
                        "base_no_gravable" => 0.00
                    ],
                    [
                        "producto_id" => "YqxgeprxLh9981cU",
                        "cantidad" => 1.00,
                        "precio" => 0.35,
                        "porcentaje_iva" => 12,
                        "porcentaje_descuento" => 0.00,
                        "base_cero" => 0.00,
                        "base_gravable" => 0.35,
                        "base_no_gravable" => 0.00,
                        "porcentaje_ice" => 0.00,
                        "valor_ice" => 0.00
                    ]
                ],
                "cobros" => [
                    [
                        "forma_cobro" => "TC",
                        "monto" => 1.51,
                        "numero_cheque" => "4567897",
                        "tipo_ping" => "D"
                    ]
                ]
            ]
        ]);
    
        return $response->getBody()->getContents();
    }

    
    
    
    
    public function consultaPagos($id)
    {
        $cabecera = DB::table('fyl_payment_participant as PP')->where('id', $id)->first(); // Suponiendo que $id es el ID de la cabecera que deseas obtener

        $program = $cabecera->program;
       
        $detalles = DB::table('fyl_payment as P')->where('fyl_payment_participant', $id)->get(); // Suponiendo que 'cabecera_id' es la clave for¨¢nea que relaciona la cabecera con el detalle
        
        $CC_RUC = $detalles->pluck('CC_RUC')->unique();
        
        foreach ($CC_RUC as $CC_RUCItem) {
            echo $this->generaComprobante($CC_RUCItem,$id,$program);
        }
    }
    
    public function generaComprobante($CC_RUCItem,$id,$program)
    {
        $cliente = DB::table('fyl_clients as C')->where('CC_RUC', $CC_RUCItem)->first(); // Suponiendo que $CC_RUCItem es el RUC que est¨¢s buscando

        $pagos = DB::table('fyl_payment as P')->where('fyl_payment_participant', $id)->where('CC_RUC', $CC_RUCItem)->get(); // Suponiendo que 'fyl_payment_participant' es la clave for¨¢nea que relaciona el pago con el participante y que $id es el ID de la cabecera que deseas obtener
        
        $subtotal_iva = 0;
        $iva = 0;
        
        foreach ($pagos as $detallePago) {
            $subtotal = $detallePago->amount / 1.12;
            $ivas = $subtotal * 0.12;
        
            $subtotal_iva += $subtotal;
            $iva += $ivas;
        }
        
        $arrayAsociativo = [
            'pos' => 'ffc3de27-fb4c-48b4-a06e-a129cf37ea99', //$cabecera->pos,
            'fecha_emision' => $pagos[0]->created_at,
            'tipo_documento' => 'PRE',
            'estado' => 'P',
            'caja_id' => '',
            'cliente' => [
                'ruc' => $cliente->CC_RUC,
                'cedula' => $cliente->CC_RUC,
                'razon_social' => $cliente->names_razon_social,
                'telefonos' => $cliente->phone,
                'direccion' => $cliente->address,
                'tipo' => 'N',
                'email' => $cliente->email,
                'es_extranjero' => false,
            ],
            'vendedor' => '',
            'descripcion' => $program,
            'subtotal_0' => 0,
            'subtotal_12' => $subtotal_iva,
            'iva' => $iva,
            'total' => $subtotal_iva + $iva,
            'adicional1' => '',
            'detalles' => $pagos->map(function ($pago) use ($program) {
                return [
                    'producto_id' => $program,
                    'cantidad' => 1,
                    'precio' => $pago->amount / 1.12,
                    'porcentaje_iva' => 12,
                    'porcentaje_descuento' => 0,
                    'base_cero' => 0.00,
                    'base_gravable' => $pago->amount / 1.12,
                    'base_no_gravable' => 0.00,
                ];
            }),
        ];
        
        $json = json_encode($arrayAsociativo);
        return $json;
    }
    
}
