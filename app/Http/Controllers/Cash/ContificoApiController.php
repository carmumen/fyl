<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cash\Producto;
use App\Models\Cash\Documentos;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ContificoApiController extends Controller
{
    // Encabezados para la autenticaciÃ³n en la API
    private $headers = [
        'Api-Token' => '3bf15e34-3a21-4407-91ea-230a3e904df2',//'dce704ae-189e-4545-bea3-257d9249a594',
        'Authorization' => 'dNAIav1gxZ54M9Gj01asH5lhpRrGBNHkzoxzwPUyVXA',//'FrguR1kDpFHaXHLQwplZ2CwTX3p8p9XHVTnukL98V5U',
    ];
    
    public function cargarProductosDesdeAPI()
    {
        Producto::truncate();
        
        $response = Http::withHeaders($this->headers)->timeout(60)->get('https://api.contifico.com/sistema/api/v1/producto/');

        $datosJson = json_decode($response, true);
        
        //return $datosJson;
        
        // Verificar si se pudo decodificar el JSON correctamente
        if ($datosJson === null && json_last_error() !== JSON_ERROR_NONE) 
        {
            // Manejar el error si la decodificaciÃ³n fallÃ³
            echo "Error al decodificar el JSON: " . json_last_error_msg();
            return;
        } 
        else 
        {
            foreach($datosJson as $datos)
            {
                $dataCreate = [ 'id' => $datos['id'],
                                'codigo' => $datos['codigo'],
                                'tipo_producto' => $datos['tipo_producto'],
                                'para_pos' => $datos['para_pos'],
                                'nombre' => $datos['nombre'],
                                'codigo_barra' => $datos['codigo_barra'],
                                'categoria_id' => $datos['categoria_id'],
                                'marca_id' => $datos['marca_id'],
                                'marca_nombre' => $datos['marca_nombre'],
                                'porcentaje_iva' => $datos['porcentaje_iva'],
                                'pvp1' => $datos['pvp1'],
                                'pvp2' => $datos['pvp2'],
                                'pvp3' => $datos['pvp3'],
                                'pvp4' => $datos['pvp4'],
                                'minimo' => $datos['minimo'],
                                'cantidad_stock' => $datos['cantidad_stock'],
                                'estado' => $datos['estado'],
                                'pvp_manual' => $datos['pvp_manual'],
                                'imagen' => $datos['imagen'],
                                'descripcion' => $datos['descripcion'],
                                'personalizado1' => $datos['personalizado1'],
                                'personalizado2' => $datos['personalizado2'],
                                'tipo' => $datos['tipo'],
                                'producto_base_id' => $datos['producto_base_id'],
                                'nombre_producto_base' => $datos['nombre_producto_base'],
                                'variantes' => $datos['variantes'],
                                'pvp_peso' => $datos['pvp_peso'],
                                'peso_desde' => $datos['peso_desde'],
                                'peso_hasta' => $datos['peso_hasta'],
                                'cuenta_venta_id' => $datos['cuenta_venta_id'],
                                'cuenta_compra_id' => $datos['cuenta_compra_id'],
                                'cuenta_costo_id' => $datos['cuenta_costo_id'],
                                'costo_maximo' => $datos['costo_maximo'],
                                'fecha_creacion' => date('Y-m-d', strtotime(str_replace('/', '-', $datos['fecha_creacion']))), // Convertir fecha al formato correcto
                                'codigo_proveedor' => $datos['codigo_proveedor'],
                                'lead_time' => $datos['lead_time'],
                                'generacion_automatica' => $datos['generacion_automatica'],
                                'id_integracion_proveedor' => $datos['id_integracion_proveedor']
                            ];
                    
                $producto = Producto::find($datos['id']);
    
                if ($producto) {
                    // El producto existe en la base de datos
                    $producto->update($dataCreate);
                } else {
                    // Agrega producto a la base de datos
                    Producto::create($dataCreate);
                }
                
                
            }
            
            return to_route('ContificoP.Productos')->with('success','Productos cargados desde la API y almacenados correctamente.');
            
        }
    }
    
    public function actualizaPreciosDesdeContifico()
    {
        DB::select('CALL fyl_prices_actualiza_precio()');
        return to_route('ContificoP.Productos')->with('success','Precios de FYL actualizados desde contifico.');
    }
    
    public function index_productos(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $search = $request->input('search') ?: '';
        $pag = $request->input('pag') ?: 20;
        
        //return response()->json($search);

        if ($search == '') {
            $search = session('search');
        }

        session(['search' => $search]);
        
        //$productos = [];
        
        $productos = Producto::paginate($pag);
        
        //return $productos;

        $userId = auth()->id();
        
        $producto = [];
        

        return view('cash/contifico/productos', [
            'producto' => $producto,
            'productos' => $productos]);
    }    
    
    public function index_documentos(Request $request)
    {
        if (!session('menus')) {
            return to_route('dashboard');
        };
        
        $buscador = $request->input('buscar') ?: '';
        $errores = $request->input('errores') ?: '';
        
        if ($buscador == '') {
            $buscador = session('buscador');
            if(strlen($buscador)<4)
                $buscador = '';
        }
        
        if ($errores == '') {
            $errores = session('errores');
        }
        
        session(['buscador' => $buscador]);
        session(['errores' => $errores]);
        
        
        $pag = $request->input('pag') ?: 15;
        
        DB::select('CALL cash_generacion_masiva_documentos_sp()');
        
        $userId = auth()->id();
        
        if($errores == 'NO')
        {
            $documentos = Documentos::select(
                    'cash_documento.id',
                    'cash_documento.fecha_emision',
                    'cash_documento.documento',
                    'cash_documento.cliente_id',
                    'fyl_clients.names_razon_social',
                    'fyl_clients.address',
                    'fyl_clients.email',
                    'cash_documento.descripcion',
                    'cash_documento.subtotal_iva',
                    'cash_documento.iva',
                    'cash_documento.total',
                    'fyl_participants.names_surnames',
                    'cash_documento.estado_json',
                    'cash_documento.comentario',
                    'cash_documento.fyl_payment_participant'
                )
                ->join('fyl_clients', 'cash_documento.cliente_id', '=', 'fyl_clients.CC_RUC')
                ->join('fyl_payment_participant', 'cash_documento.fyl_payment_participant', '=', 'fyl_payment_participant.id')
                ->join('fyl_participants', 'fyl_payment_participant.participant_DNI', '=', 'fyl_participants.DNI')
                ->where('fyl_clients.names_razon_social', 'LIKE', '%'.$buscador.'%')
                ->orderByRaw("CASE cash_documento.estado_json 
                                     WHEN 'GENERADO' THEN 1
                                     WHEN 'CON ERROR' THEN 2
                                     WHEN 'ENVIADO' THEN 3
                                     ELSE 4
                                 END")
                ->paginate($pag);
        }
        else
        {
            $documentos = Documentos::select(
                    'cash_documento.id',
                    'cash_documento.fecha_emision',
                    'cash_documento.documento',
                    'cash_documento.cliente_id',
                    'fyl_clients.names_razon_social',
                    'fyl_clients.address',
                    'fyl_clients.email',
                    'cash_documento.descripcion',
                    'cash_documento.subtotal_iva',
                    'cash_documento.iva',
                    'cash_documento.total',
                    'fyl_participants.names_surnames',
                    'cash_documento.estado_json',
                    'cash_documento.comentario',
                    'cash_documento.fyl_payment_participant'
                )
                ->join('fyl_clients', 'cash_documento.cliente_id', '=', 'fyl_clients.CC_RUC')
                ->join('fyl_payment_participant', 'cash_documento.fyl_payment_participant', '=', 'fyl_payment_participant.id')
                ->join('fyl_participants', 'fyl_payment_participant.participant_DNI', '=', 'fyl_participants.DNI')
                ->where('fyl_clients.names_razon_social', 'LIKE', '%'.$buscador.'%')
                ->where('cash_documento.estado_json', 'CON ERROR')
                ->orderByRaw("CASE cash_documento.estado_json 
                                     WHEN 'GENERADO' THEN 1
                                     WHEN 'CON ERROR' THEN 2
                                     WHEN 'ENVIADO' THEN 3
                                     ELSE 4
                                 END")
                ->paginate($pag);
        }
        
            
            
        $contador = ($documentos->currentPage() - 1) * $documentos->perPage() + 1;

        // Asignar el n¨²mero secuencial a cada registro
        foreach ($documentos as $documentosItem) {
            $documentosItem->secuencial = $contador;
            $documentosItem->usuario = $userId;
            $documentosItem->pagos = $this->cargaPagos($documentosItem->fyl_payment_participant);
            $contador++;
        }
        
        //return $documentos;

        $userId = auth()->id();
        
        $producto = [];

        return view('cash/contifico/documentos',[
            'documentos' => $documentos,
            'buscar' => $buscador,
            'errores' => $errores
            ]);
    }   
    
    public function consultaPrecios($id)
    {
        $result = DB::table('cash_productos')
            ->select('pvp1', 'pvp2', 'pvp3', 'pvp4', 'porcentaje_iva')
            ->where('id', $id)
            ->first();
        
        if ($result) {
            $pvpArray = [
                'pvp1' => isset($result->pvp1) ? number_format($result->pvp1 * (1 + $result->porcentaje_iva / 100), 2, '.', '') : '0.00',
                'pvp2' => isset($result->pvp2) ? number_format($result->pvp2 * (1 + $result->porcentaje_iva / 100), 2, '.', '') : '0.00',
                'pvp3' => isset($result->pvp3) ? number_format($result->pvp3 * (1 + $result->porcentaje_iva / 100), 2, '.', '') : '0.00',
                'pvp4' => isset($result->pvp4) ? number_format($result->pvp4 * (1 + $result->porcentaje_iva / 100), 2, '.', '') : '0.00',
            ];

            // Imprime el arreglo
            return response()->json($pvpArray);
        } else {
            echo "No se encontraron resultados.";
        }
    }
    
    public function cargaPagos($fyl_payment_participant)
    {
        $record_payment = DB::select('CALL get_fyl_payment_participant_for_id(?)', [$fyl_payment_participant]);
        return $record_payment;
    }
     
    public function envia_documento(Request $request)
    {
        $id = $request->input('id');
        //$id=84;
        $documentos = Documentos::where('id', $id)->first();
        $cliente = $documentos->cliente_json;
        $identidad_cliente = $documentos->cliente_id;
        $documento = $documentos->documento_json;
        $detalles = $documentos->detalle_json;
        $cobros = $documentos->cobros_json;
        
        if ($documentos) {
            $documento = json_decode($documentos->documento_json, true); // Decodificar el JSON a un array asociativo
            
            // Reemplazar el valor de 'cobros' con lo que hay en $cobros
            $documento['cobros'] = json_decode($documentos->cobros_json, true);
            
            // Reemplazar el valor de 'detalle' con lo que hay en $detalle
            $documento['detalles'] = json_decode($documentos->detalle_json, true);
            
        }
        
        //return $documento;
        $clienteJson = json_decode($cliente);
        
        
        $headers = [
            'Api-Token' => 'dce704ae-189e-4545-bea3-257d9249a594',
            'Authorization' => 'FrguR1kDpFHaXHLQwplZ2CwTX3p8p9XHVTnukL98V5U',
        ];
        
        $responseCliente = Http::withHeaders($headers)->timeout(60)->post('https://api.contifico.com/sistema/api/v1/persona/?pos=dce704ae-189e-4545-bea3-257d9249a594',$clienteJson);
        
        //$responseCliente = Http::withHeaders($this->headers)->timeout(60)->post('https://api.contifico.com/sistema/api/v1/persona/?pos=dce704ae-189e-4545-bea3-257d9249a594',$clienteJson);
        
        $arrayCliente = $responseCliente->json();
        
        //return $arrayCliente;
        
        if (array_key_exists('cod_error', $arrayCliente)) 
        {
            if ($arrayCliente['cod_error'] != 1501)
            {
                $estado = 'CON ERROR';
                $comentario = 'Error en el cliente. '.$arrayCliente['mensaje'];
                $data = [ 'estado_json' => $estado,
                          'comentario' => $comentario];
                $documentos->update($data);
                return response()->json(['estado' => $estado, 'comentario' => $comentario ]);
            }   
            
            if ($arrayCliente['cod_error'] == 1501)
            {
                if (array_key_exists('id', $arrayCliente)) 
                {
                    // Accede al valor del campo "id"
                    $idRespuesta = $arrayCliente['id'];
                    
                    $arrayClienteJson = json_decode($cliente, true);
            
                    // Modifica el valor del campo "id" en el array
                    $arrayClienteJson['id'] = $idRespuesta;
                    
                    // Codifica el array modificado de vuelta a JSON
                    $clienteJsonModificado = json_encode($arrayClienteJson);
                    
                    $response = Http::withHeaders($this->headers)->timeout(60)->put('https://api.contifico.com/sistema/api/v1/persona/?pos=dce704ae-189e-4545-bea3-257d9249a594',$arrayClienteJson);
                }
            }
            
        }
        
            
        
        $responseDocumento = Http::withHeaders($this->headers)->timeout(60)->post('https://api.contifico.com/sistema/api/v1/documento/',$documento);
        
        $arrayDocumento = $responseDocumento->json();
        
        //return $arrayDocumento;
        
        if (array_key_exists('cod_error', $arrayDocumento)) {
            $estado = 'CON ERROR';
            $comentario = 'Error en el documento. '.$arrayDocumento['mensaje'];
            $data = [ 'estado_json' => $estado,
                      'comentario' => $comentario];
            $documentos->update($data);
            return response()->json(['estado' => $estado, 'comentario' => $comentario ]);
        }
        
        
        
        if (array_key_exists('id', $arrayDocumento)) {
            $estado = 'ENVIADO';
            $comentario = 'Env&iacute;o exitoso';
            $comentario = html_entity_decode($comentario, ENT_QUOTES, 'UTF-8');
            $data = [ 'estado_json' => $estado,
                      'id_contifico' => $arrayDocumento['id'],
                      'comentario' => $comentario];
            $documentos->update($data);
            
            return response()->json(['estado' => $estado, 'comentario' => $comentario ]);
        } 
            
    }
    
    
    public function actualiza_documento(Request $request)
    {
        $id = $request->input('documento_id');
        $comment = $request->input('comment');
        
        $userId = auth()->id();
        
        $usuario = DB::table('users')->select('name')->where('id',$userId)->first();
        
        $comentario = $comment . '|' . $usuario->name;
        
        
        $documentos = Documentos::where('id', $id)->first();
        
        $data = [
            'estado_json'=>'REGISTRO MANUAL',
            'comentario' => $comentario
            ];
        
        $documentos->update($data);
        
        return response()->json(['comentario' => $comentario ]);
    }
    
}
