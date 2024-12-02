<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalCatalogTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('global_catalog_types')->delete();

        DB::table('global_catalog_types')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Género',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:09:58',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Estado Civíl',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:10:14',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Nivel de Estudios',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 17:10:29',
                'updated_at' => '2023-05-20 17:10:29',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Forma de Pago',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:04:57',
                'updated_at' => '2023-08-07 10:20:22',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Tipo Tarjeta',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:10:12',
                'updated_at' => '2023-05-21 21:10:12',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Tipo de Pago',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:12:34',
                'updated_at' => '2023-05-21 21:12:34',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Etapa de vida',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:12:34',
                'updated_at' => '2023-05-21 21:12:34',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Bancos',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Currency',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 00:47:25',
                'updated_at' => '2023-08-07 00:47:25',
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Registro de Pagos',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 10:22:50',
                'updated_at' => '2023-08-07 10:22:50',
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Llamadas',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 10:22:50',
                'updated_at' => '2023-08-07 10:22:50',
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Tipo Precio',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 10:22:50',
                'updated_at' => '2023-08-07 10:22:50',
            ),
        ));


    }
}
