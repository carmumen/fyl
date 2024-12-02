<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalCatalogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('global_catalogs')->delete();

        DB::table('global_catalogs')->insert(array (
            0 =>
            array (
                'id' => 1,
                'catalog_types_id' => 1,
                'name' => 'Masculino',
                'acronym' => 'M',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:11:52',
            ),
            1 =>
            array (
                'id' => 2,
                'catalog_types_id' => 1,
                'name' => 'Femenino',
                'acronym' => 'F',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:11:44',
            ),
            2 =>
            array (
                'id' => 3,
                'catalog_types_id' => 2,
                'name' => 'Soltero',
                'acronym' => 'S',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:11:19',
            ),
            3 =>
            array (
                'id' => 4,
                'catalog_types_id' => 2,
                'name' => 'Casado',
                'acronym' => 'C',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:11:09',
            ),
            4 =>
            array (
                'id' => 5,
                'catalog_types_id' => 2,
                'name' => 'Viudo',
                'acronym' => 'V',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:11:33',
            ),
            5 =>
            array (
                'id' => 6,
                'catalog_types_id' => 2,
                'name' => 'Divorciado',
                'acronym' => 'D',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:10:41',
            ),
            6 =>
            array (
                'id' => 7,
                'catalog_types_id' => 2,
                'name' => 'Unión Libre',
                'acronym' => 'UL',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => '2023-05-20 17:10:59',
            ),
            7 =>
            array (
                'id' => 8,
                'catalog_types_id' => 3,
                'name' => 'Primaria',
                'acronym' => 'P',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 17:13:18',
                'updated_at' => '2023-05-20 17:13:18',
            ),
            8 =>
            array (
                'id' => 9,
                'catalog_types_id' => 3,
                'name' => 'Secundaria',
                'acronym' => 'S',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 17:13:33',
                'updated_at' => '2023-05-20 17:13:33',
            ),
            9 =>
            array (
                'id' => 10,
                'catalog_types_id' => 3,
                'name' => 'Tercer Nivel',
                'acronym' => 'TN',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 17:14:02',
                'updated_at' => '2023-05-20 17:14:02',
            ),
            10 =>
            array (
                'id' => 11,
                'catalog_types_id' => 3,
                'name' => 'Cuarto Nivel',
                'acronym' => 'CN',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 17:14:17',
                'updated_at' => '2023-05-20 17:14:17',
            ),
            11 =>
            array (
                'id' => 12,
                'catalog_types_id' => 4,
                'name' => 'Tarjeta de Crédito',
                'acronym' => 'TC',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:06:00',
                'updated_at' => '2023-05-21 21:06:00',
            ),
            12 =>
            array (
                'id' => 13,
                'catalog_types_id' => 4,
                'name' => 'Tarjeta de Débito',
                'acronym' => 'TD',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:06:34',
                'updated_at' => '2023-05-21 21:06:34',
            ),
            13 =>
            array (
                'id' => 14,
                'catalog_types_id' => 4,
                'name' => 'Transferencia',
                'acronym' => 'TRNS',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:06:53',
                'updated_at' => '2023-05-21 21:06:53',
            ),
            14 =>
            array (
                'id' => 15,
                'catalog_types_id' => 4,
                'name' => 'Depósito',
                'acronym' => 'DEPO',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:07:15',
                'updated_at' => '2023-05-21 21:07:15',
            ),
            15 =>
            array (
                'id' => 16,
                'catalog_types_id' => 4,
                'name' => 'Efectivo',
                'acronym' => 'Efec',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:07:39',
                'updated_at' => '2023-05-21 21:07:39',
            ),
            16 =>
            array (
                'id' => 17,
                'catalog_types_id' => 5,
                'name' => 'Visa',
                'acronym' => 'Visa',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:10:25',
                'updated_at' => '2023-05-21 21:12:21',
            ),
            17 =>
            array (
                'id' => 18,
                'catalog_types_id' => 5,
                'name' => 'Master Card',
                'acronym' => 'Master C.',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:10:39',
                'updated_at' => '2023-05-21 21:12:06',
            ),
            18 =>
            array (
                'id' => 19,
                'catalog_types_id' => 5,
                'name' => 'Diners',
                'acronym' => 'Diners',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:10:54',
                'updated_at' => '2023-05-21 21:10:54',
            ),
            19 =>
            array (
                'id' => 20,
                'catalog_types_id' => 5,
                'name' => 'American Express',
                'acronym' => 'AME. EXP.',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:11:18',
                'updated_at' => '2023-05-21 21:11:18',
            ),
            20 =>
            array (
                'id' => 21,
                'catalog_types_id' => 5,
                'name' => 'Otra',
                'acronym' => 'O',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:11:31',
                'updated_at' => '2023-05-21 21:11:31',
            ),
            21 =>
            array (
                'id' => 22,
                'catalog_types_id' => 6,
                'name' => '1 mes',
                'acronym' => '1',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:12:49',
                'updated_at' => '2023-08-09 03:00:41',
            ),
            22 =>
            array (
                'id' => 23,
                'catalog_types_id' => 6,
                'name' => 'Corriente',
                'acronym' => '0',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:13:01',
                'updated_at' => '2023-08-09 02:57:41',
            ),
            23 =>
            array (
                'id' => 24,
                'catalog_types_id' => 7,
                'name' => 'Adolescente',
                'acronym' => 'ADO',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:13:01',
                'updated_at' => '2023-05-21 21:13:01',
            ),
            24 =>
            array (
                'id' => 25,
                'catalog_types_id' => 7,
                'name' => 'Adulto',
                'acronym' => 'ADU',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-21 21:13:01',
                'updated_at' => '2023-05-21 21:13:01',
            ),
            25 =>
            array (
                'id' => 27,
                'catalog_types_id' => 8,
                'name' => 'Amazonas',
                'acronym' => 'AM',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:54',
                'updated_at' => '2023-08-05 03:24:54',
            ),
            26 =>
            array (
                'id' => 28,
                'catalog_types_id' => 8,
                'name' => 'Bolivariano',
                'acronym' => 'Bol',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:25:10',
                'updated_at' => '2023-08-05 03:25:10',
            ),
            27 =>
            array (
                'id' => 29,
                'catalog_types_id' => 8,
                'name' => 'Banco de Loja',
                'acronym' => 'BL',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 16:10:11',
                'updated_at' => '2023-08-05 16:10:11',
            ),
            28 =>
            array (
                'id' => 30,
                'catalog_types_id' => 8,
                'name' => 'BanEcuador',
                'acronym' => 'BE',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 16:10:44',
                'updated_at' => '2023-08-05 16:10:44',
            ),
            29 =>
            array (
                'id' => 31,
                'catalog_types_id' => 8,
                'name' => 'Banco del Azuay',
                'acronym' => 'BAY',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 16:11:15',
                'updated_at' => '2023-08-05 16:11:15',
            ),
            30 =>
            array (
                'id' => 32,
                'catalog_types_id' => 8,
                'name' => 'Banco Solidario',
                'acronym' => 'BS',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            31 =>
            array (
                'id' => 33,
                'catalog_types_id' => 8,
                'name' => 'Banco Produbanco',
                'acronym' => 'BPR',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            32 =>
            array (
                'id' => 34,
                'catalog_types_id' => 8,
                'name' => 'Banco Pichincha',
                'acronym' => 'BPI',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            33 =>
            array (
                'id' => 35,
                'catalog_types_id' => 8,
                'name' => 'Banco Internacional',
                'acronym' => 'BI',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            34 =>
            array (
                'id' => 36,
                'catalog_types_id' => 8,
                'name' => 'Banco Procredit',
                'acronym' => 'BPRC',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            35 =>
            array (
                'id' => 37,
                'catalog_types_id' => 8,
                'name' => 'Banco de Guayaquil',
                'acronym' => 'BG',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            36 =>
            array (
                'id' => 38,
                'catalog_types_id' => 8,
                'name' => 'Banco General Rumiñahui',
                'acronym' => 'BR',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            37 =>
            array (
                'id' => 39,
                'catalog_types_id' => 8,
                'name' => 'Banco del Pacífico',
                'acronym' => 'BPAC',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            38 =>
            array (
                'id' => 40,
                'catalog_types_id' => 8,
                'name' => 'Banco del Austro',
                'acronym' => 'BAUS',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            39 =>
            array (
                'id' => 41,
                'catalog_types_id' => 8,
                'name' => 'Banco Comercial de Manabí',
                'acronym' => 'BCM',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            40 =>
            array (
                'id' => 42,
                'catalog_types_id' => 8,
                'name' => 'Banco Coopnacional',
                'acronym' => 'BCNAC',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            41 =>
            array (
                'id' => 43,
                'catalog_types_id' => 8,
                'name' => 'Banco D-Miro',
                'acronym' => 'BDM',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            42 =>
            array (
                'id' => 44,
                'catalog_types_id' => 8,
                'name' => 'Banco Finca',
                'acronym' => 'BF',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            43 =>
            array (
                'id' => 45,
                'catalog_types_id' => 8,
                'name' => 'Banco Litoral',
                'acronym' => 'BLIT',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            44 =>
            array (
                'id' => 46,
                'catalog_types_id' => 8,
                'name' => 'Bancodesarrollo',
                'acronym' => 'BDES',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            45 =>
            array (
                'id' => 47,
                'catalog_types_id' => 8,
                'name' => 'Banco Diners Club del Ecuador',
                'acronym' => 'BDCLUB',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            46 =>
            array (
                'id' => 48,
                'catalog_types_id' => 8,
                'name' => 'Banco VisionFund',
                'acronym' => 'BVF',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-05 03:24:33',
                'updated_at' => '2023-08-05 03:24:33',
            ),
            47 =>
            array (
                'id' => 49,
                'catalog_types_id' => 9,
                'name' => 'Dólares',
                'acronym' => '$',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 00:48:21',
                'updated_at' => '2023-08-07 00:48:21',
            ),
            48 =>
            array (
                'id' => 50,
                'catalog_types_id' => 9,
                'name' => 'Pesos Colombianos',
            'acronym' => 'COP ($)',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 00:49:57',
                'updated_at' => '2023-08-07 00:49:57',
            ),
            49 =>
            array (
                'id' => 51,
                'catalog_types_id' => 10,
                'name' => 'Pago Total',
                'acronym' => 'PT',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 10:23:13',
                'updated_at' => '2023-08-08 03:18:20',
            ),
            50 =>
            array (
                'id' => 52,
                'catalog_types_id' => 10,
                'name' => 'Abono',
                'acronym' => 'A',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-07 10:23:36',
                'updated_at' => '2023-08-07 10:23:36',
            ),
            51 =>
            array (
                'id' => 53,
                'catalog_types_id' => 6,
                'name' => '2 meses',
                'acronym' => '2',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:56:16',
                'updated_at' => '2023-08-09 02:56:16',
            ),
            52 =>
            array (
                'id' => 54,
                'catalog_types_id' => 6,
                'name' => '3 meses',
                'acronym' => '3',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:56:35',
                'updated_at' => '2023-08-09 02:56:35',
            ),
            53 =>
            array (
                'id' => 55,
                'catalog_types_id' => 6,
                'name' => '4 meses',
                'acronym' => '4',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:56:49',
                'updated_at' => '2023-08-09 02:56:49',
            ),
            54 =>
            array (
                'id' => 56,
                'catalog_types_id' => 6,
                'name' => '5 meses',
                'acronym' => '5',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:57:54',
                'updated_at' => '2023-08-09 02:57:54',
            ),
            55 =>
            array (
                'id' => 57,
                'catalog_types_id' => 6,
                'name' => '6 meses',
                'acronym' => '6',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:58:11',
                'updated_at' => '2023-08-09 02:58:11',
            ),
            56 =>
            array (
                'id' => 58,
                'catalog_types_id' => 6,
                'name' => '9 meses',
                'acronym' => '9',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:58:27',
                'updated_at' => '2023-08-09 02:58:27',
            ),
            57 =>
            array (
                'id' => 59,
                'catalog_types_id' => 6,
                'name' => '10 meses',
                'acronym' => '10',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:58:42',
                'updated_at' => '2023-08-09 02:58:42',
            ),
            58 =>
            array (
                'id' => 60,
                'catalog_types_id' => 6,
                'name' => '12 meses',
                'acronym' => '12',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 02:59:02',
                'updated_at' => '2023-08-09 02:59:02',
            ),
            59 =>
            array (
                'id' => 61,
                'catalog_types_id' => 6,
                'name' => '18 meses',
                'acronym' => '18',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:00',
                'updated_at' => '2023-08-09 03:00:00',
            ),
            60 =>
            array (
                'id' => 62,
                'catalog_types_id' => 6,
                'name' => '24 meses',
                'acronym' => '24',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),


            61 =>
            array (
                'id' => 63,
                'catalog_types_id' => 11,
                'name' => 'CONFIRMADO',
                'acronym' => 'SI',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            62 =>
            array (
                'id' => 64,
                'catalog_types_id' => 11,
                'name' => 'NO CONTESTA',
                'acronym' => 'NC',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            63 =>
            array (
                'id' => 65,
                'catalog_types_id' => 11,
                'name' => 'PRÓXIMA FECHA',
                'acronym' => 'PF',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            64 =>
            array (
                'id' => 66,
                'catalog_types_id' => 11,
                'name' => 'SIN LLAMAR',
                'acronym' => 'SLL',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            65 =>
            array (
                'id' => 67,
                'catalog_types_id' => 11,
                'name' => 'NO INTERESA',
                'acronym' => 'NI',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            66 =>
            array (
                'id' => 68,
                'catalog_types_id' => 11,
                'name' => 'POR CONFIRMAR',
                'acronym' => 'PC',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            67 =>
            array (
                'id' => 69,
                'catalog_types_id' => 12,
                'name' => 'NORMAL',
                'acronym' => 'N',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            68 =>
            array (
                'id' => 70,
                'catalog_types_id' => 12,
                'name' => 'MASTER LIFE',
                'acronym' => 'MF',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            69 =>
            array (
                'id' => 71,
                'catalog_types_id' => 12,
                'name' => 'FIN DE SEMANA',
                'acronym' => 'FDS',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
            70 =>
            array (
                'id' => 72,
                'catalog_types_id' => 6,
                'name' => 'BECA',
                'acronym' => 'B',
                'status' => 'ACTIVE',
                'created_at' => '2023-08-09 03:00:16',
                'updated_at' => '2023-08-09 03:00:16',
            ),
        ));


    }
}
