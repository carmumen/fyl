<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Cash\Producto;

class ProcesarProductosContificoApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Encabezados requeridos para la autenticaci¨®n
        $headers = [
            'Api-Token' => 'dce704ae-189e-4545-bea3-257d9249a594',
            'Authorization' => 'FrguR1kDpFHaXHLQwplZ2CwTX3p8p9XHVTnukL98V5U',
        ];

        // Realizar la solicitud a la API con los encabezados
        $response = Http::withHeaders($headers)->get('https://api.contifico.com/sistema/api/v1/producto/');

        
        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Obtener los datos de la respuesta
            $data = $response->json();

            // Recorrer los datos y guardarlos en la base de datos
            foreach ($data as $producto) {
                Producto::create([
                    'id' => $producto['id'],
                    'codigo' => $producto['codigo'],
                    'tipo_producto' => $producto['tipo_producto'],
                    'para_pos' => $producto['para_pos'],
                    'nombre' => $producto['nombre'],
                    'codigo_barra' => $producto['codigo_barra'],
                    'categoria_id' => $producto['categoria_id'],
                    'marca_id' => $producto['marca_id'],
                    'marca_nombre' => $producto['marca_nombre'],
                    'porcentaje_iva' => $producto['porcentaje_iva'],
                    'pvp1' => $producto['pvp1'],
                    'pvp2' => $producto['pvp2'],
                    'pvp3' => $producto['pvp3'],
                    'pvp4' => $producto['pvp4'],
                    'minimo' => $producto['minimo'],
                    'cantidad_stock' => $producto['cantidad_stock'],
                    'estado' => $producto['estado'],
                    'pvp_manual' => $producto['pvp_manual'],
                    'imagen' => $producto['imagen'],
                    'descripcion' => $producto['descripcion'],
                    'personalizado1' => $producto['personalizado1'],
                    'personalizado2' => $producto['personalizado2'],
                    'tipo' => $producto['tipo'],
                    'producto_base_id' => $producto['producto_base_id'],
                    'nombre_producto_base' => $producto['nombre_producto_base'],
                    'variantes' => $producto['variantes'],
                    'pvp_peso' => $producto['pvp_peso'],
                    'peso_desde' => $producto['peso_desde'],
                    'peso_hasta' => $producto['peso_hasta'],
                    'cuenta_venta_id' => $producto['cuenta_venta_id'],
                    'cuenta_compra_id' => $producto['cuenta_compra_id'],
                    'cuenta_costo_id' => $producto['cuenta_costo_id'],
                    'costo_maximo' => $producto['costo_maximo'],
                    'fecha_creacion' => date('Y-m-d', strtotime(str_replace('/', '-', $producto['fecha_creacion']))), // Convertir fecha al formato correcto
                    'codigo_proveedor' => $producto['codigo_proveedor'],
                    'lead_time' => $producto['lead_time'],
                    'generacion_automatica' => $producto['generacion_automatica'],
                    'id_integracion_proveedor' => $producto['id_integracion_proveedor']
                ]);
            }

            return response()->json(['message' => 'Datos cargados desde la API y almacenados correctamente'], 200);
        } else {
            // Si la solicitud no fue exitosa, devolver un mensaje de error
            return response()->json(['error' => 'Error al obtener los datos de la API'], $response->status());
        }
    }
}
