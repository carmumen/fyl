<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('global_provinces')->delete();

        DB::table('global_provinces')->insert(array (
            0 =>
            array (
                'id' => 1,
                'country_id' => 1,
                'code' => '01',
                'name' => 'AZUAY',
                'code_RDEP' => '201',
                'code_MAP' => 'EC-A',
                'acronym' => 'A',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'country_id' => 1,
                'code' => '02',
                'name' => 'BOLIVAR',
                'code_RDEP' => '202',
                'code_MAP' => 'EC-B',
                'acronym' => 'B',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'country_id' => 1,
                'code' => '03',
                'name' => 'CAÑAR',
                'code_RDEP' => '203',
                'code_MAP' => 'EC-F',
                'acronym' => 'CÑ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'country_id' => 1,
                'code' => '04',
                'name' => 'CARCHI',
                'code_RDEP' => '204',
                'code_MAP' => 'EC-C',
                'acronym' => 'C',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'country_id' => 1,
                'code' => '05',
                'name' => 'COTOPAXI',
                'code_RDEP' => '205',
                'code_MAP' => 'EC-X',
                'acronym' => 'CPX',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'country_id' => 1,
                'code' => '06',
                'name' => 'CHIMBORAZO',
                'code_RDEP' => '206',
                'code_MAP' => 'EC-H',
                'acronym' => 'CH',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'country_id' => 1,
                'code' => '07',
                'name' => 'EL ORO',
                'code_RDEP' => '107',
                'code_MAP' => 'EC-O',
                'acronym' => 'EO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'country_id' => 1,
                'code' => '08',
                'name' => 'ESMERALDAS',
                'code_RDEP' => '108',
                'code_MAP' => 'EC-E',
                'acronym' => 'E',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'country_id' => 1,
                'code' => '09',
                'name' => 'GUAYAS',
                'code_RDEP' => '109',
                'code_MAP' => 'EC-G',
                'acronym' => 'GY',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'country_id' => 1,
                'code' => '10',
                'name' => 'IMBABURA',
                'code_RDEP' => '210',
                'code_MAP' => 'EC-I',
                'acronym' => 'I',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'country_id' => 1,
                'code' => '11',
                'name' => 'LOJA',
                'code_RDEP' => '211',
                'code_MAP' => 'EC-L',
                'acronym' => 'L',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'country_id' => 1,
                'code' => '12',
                'name' => 'LOS RIOS',
                'code_RDEP' => '112',
                'code_MAP' => 'EC-R',
                'acronym' => 'LR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'country_id' => 1,
                'code' => '13',
                'name' => 'MANABI',
                'code_RDEP' => '113',
                'code_MAP' => 'EC-M',
                'acronym' => 'M',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'country_id' => 1,
                'code' => '14',
                'name' => 'MORONA SANTIAGO',
                'code_RDEP' => '314',
                'code_MAP' => 'EC-S',
                'acronym' => 'MS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'country_id' => 1,
                'code' => '15',
                'name' => 'NAPO',
                'code_RDEP' => '315',
                'code_MAP' => 'EC-N',
                'acronym' => 'N',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'country_id' => 1,
                'code' => '16',
                'name' => 'PASTAZA',
                'code_RDEP' => '316',
                'code_MAP' => 'EC-Y',
                'acronym' => 'P',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'country_id' => 1,
                'code' => '17',
                'name' => 'PICHINCHA',
                'code_RDEP' => '217',
                'code_MAP' => 'EC-P',
                'acronym' => 'PCH',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'country_id' => 1,
                'code' => '18',
                'name' => 'TUNGURAHUA',
                'code_RDEP' => '218',
                'code_MAP' => 'EC-T',
                'acronym' => 'T',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'country_id' => 1,
                'code' => '19',
                'name' => 'ZAMORA CHINCHIPE',
                'code_RDEP' => '319',
                'code_MAP' => 'EC-Z',
                'acronym' => 'ZCH',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'country_id' => 1,
                'code' => '20',
                'name' => 'GALÁPAGOS',
                'code_RDEP' => '420',
                'code_MAP' => 'EC-W',
                'acronym' => 'G',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'country_id' => 1,
                'code' => '21',
                'name' => 'SUCUMBIOS',
                'code_RDEP' => '321',
                'code_MAP' => 'EC-U',
                'acronym' => 'S',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'country_id' => 1,
                'code' => '22',
                'name' => 'ORELLANA',
                'code_RDEP' => '322',
                'code_MAP' => 'EC-D',
                'acronym' => 'O',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'country_id' => 1,
                'code' => '23',
                'name' => 'SANTO DOMINGO DE LOS TSACHILAS',
                'code_RDEP' => '223',
                'code_MAP' => 'EC-SD',
                'acronym' => 'SDT',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'country_id' => 1,
                'code' => '24',
                'name' => 'SANTA ELENA',
                'code_RDEP' => '124',
                'code_MAP' => 'EC-SE',
                'acronym' => 'SE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'country_id' => 46,
                'code' => '5',
                'name' => 'ANTIOQUIA',
                'code_RDEP' => NULL,
                'code_MAP' => NULL,
                'acronym' => 'A',
                'status' => 'ACTIVE',
                'created_at' => '2023-05-25 01:18:48',
                'updated_at' => '2023-05-25 01:18:48',
            ),
        ));


    }
}
