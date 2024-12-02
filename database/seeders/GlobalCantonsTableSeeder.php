<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalCantonsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('global_cantons')->delete();

        DB::table('global_cantons')->insert(array (
            0 =>
            array (
                'id' => 1,
                'province_id' => 9,
                'code' => '15',
                'name' => 'SALINAS',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'province_id' => 9,
                'code' => '17',
                'name' => 'SANTA ELENA',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'province_id' => 9,
                'code' => '26',
                'name' => 'LA LIBERTAD',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'province_id' => 1,
                'code' => '01',
                'name' => 'CUENCA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'province_id' => 1,
                'code' => '02',
                'name' => 'GIRON',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'province_id' => 1,
                'code' => '03',
                'name' => 'GUALACEO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'province_id' => 1,
                'code' => '04',
                'name' => 'NABON',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'province_id' => 1,
                'code' => '05',
                'name' => 'PAUTE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'province_id' => 1,
                'code' => '06',
                'name' => 'PUCARA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'province_id' => 1,
                'code' => '07',
                'name' => 'SAN FERNANDO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'province_id' => 1,
                'code' => '08',
                'name' => 'SANTA ISABEL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'province_id' => 1,
                'code' => '09',
                'name' => 'SIGSIG',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'province_id' => 1,
                'code' => '10',
                'name' => 'OÑA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'province_id' => 1,
                'code' => '11',
                'name' => 'CHORDELEG',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'province_id' => 1,
                'code' => '12',
                'name' => 'EL PAN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'province_id' => 1,
                'code' => '13',
                'name' => 'SEVILLA DE ORO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'province_id' => 1,
                'code' => '14',
                'name' => 'GUACHAPALA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'province_id' => 1,
                'code' => '15',
                'name' => 'CAMILO PONCE ENRIQUEZ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'province_id' => 2,
                'code' => '01',
                'name' => 'GUARANDA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'province_id' => 2,
                'code' => '02',
                'name' => 'CHILLANES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'province_id' => 2,
                'code' => '03',
                'name' => 'CHIMBO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'province_id' => 2,
                'code' => '04',
                'name' => 'ECHEANDÍA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'province_id' => 2,
                'code' => '05',
                'name' => 'SAN MIGUEL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'province_id' => 2,
                'code' => '06',
                'name' => 'CALUMA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'province_id' => 2,
                'code' => '07',
                'name' => 'LAS NAVES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 =>
            array (
                'id' => 26,
                'province_id' => 3,
                'code' => '01',
                'name' => 'AZOGUES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 =>
            array (
                'id' => 27,
                'province_id' => 3,
                'code' => '02',
                'name' => 'BIBLIAN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 =>
            array (
                'id' => 28,
                'province_id' => 3,
                'code' => '03',
                'name' => 'CAÑAR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 =>
            array (
                'id' => 29,
                'province_id' => 3,
                'code' => '04',
                'name' => 'LA TRONCAL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 =>
            array (
                'id' => 30,
                'province_id' => 3,
                'code' => '05',
                'name' => 'EL TAMBO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 =>
            array (
                'id' => 31,
                'province_id' => 3,
                'code' => '06',
                'name' => 'DELEG',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 =>
            array (
                'id' => 32,
                'province_id' => 3,
                'code' => '07',
                'name' => 'SUSCAL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 =>
            array (
                'id' => 33,
                'province_id' => 4,
                'code' => '01',
                'name' => 'TULCAN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 =>
            array (
                'id' => 34,
                'province_id' => 4,
                'code' => '02',
                'name' => 'BOLIVAR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 =>
            array (
                'id' => 35,
                'province_id' => 4,
                'code' => '03',
                'name' => 'ESPEJO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 =>
            array (
                'id' => 36,
                'province_id' => 4,
                'code' => '04',
                'name' => 'MIRA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 =>
            array (
                'id' => 37,
                'province_id' => 4,
                'code' => '05',
                'name' => 'MONTUFAR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 =>
            array (
                'id' => 38,
                'province_id' => 4,
                'code' => '06',
                'name' => 'SAN PEDRO DE HUACA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 =>
            array (
                'id' => 39,
                'province_id' => 5,
                'code' => '01',
                'name' => 'LATACUNGA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 =>
            array (
                'id' => 40,
                'province_id' => 5,
                'code' => '02',
                'name' => 'LA MANÁ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 =>
            array (
                'id' => 41,
                'province_id' => 5,
                'code' => '03',
                'name' => 'PANGUA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 =>
            array (
                'id' => 42,
                'province_id' => 5,
                'code' => '04',
                'name' => 'PUJILÍ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 =>
            array (
                'id' => 43,
                'province_id' => 5,
                'code' => '05',
                'name' => 'SALCEDO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 =>
            array (
                'id' => 44,
                'province_id' => 5,
                'code' => '06',
                'name' => 'SAQUISILÍ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 =>
            array (
                'id' => 45,
                'province_id' => 5,
                'code' => '07',
                'name' => 'SIGCHOS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 =>
            array (
                'id' => 46,
                'province_id' => 6,
                'code' => '01',
                'name' => 'RIOBAMBA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 =>
            array (
                'id' => 47,
                'province_id' => 6,
                'code' => '02',
                'name' => 'ALAUSI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 =>
            array (
                'id' => 48,
                'province_id' => 6,
                'code' => '03',
                'name' => 'COLTA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 =>
            array (
                'id' => 49,
                'province_id' => 6,
                'code' => '04',
                'name' => 'CHAMBO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 =>
            array (
                'id' => 50,
                'province_id' => 6,
                'code' => '05',
                'name' => 'CHUNCHI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 =>
            array (
                'id' => 51,
                'province_id' => 6,
                'code' => '06',
                'name' => 'GUAMOTE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 =>
            array (
                'id' => 52,
                'province_id' => 6,
                'code' => '07',
                'name' => 'GUANO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 =>
            array (
                'id' => 53,
                'province_id' => 6,
                'code' => '08',
                'name' => 'PALLATANGA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 =>
            array (
                'id' => 54,
                'province_id' => 6,
                'code' => '09',
                'name' => 'PENIPE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 =>
            array (
                'id' => 55,
                'province_id' => 6,
                'code' => '10',
                'name' => 'CUMANDA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 =>
            array (
                'id' => 56,
                'province_id' => 7,
                'code' => '01',
                'name' => 'MACHALA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 =>
            array (
                'id' => 57,
                'province_id' => 7,
                'code' => '02',
                'name' => 'ARENILLAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 =>
            array (
                'id' => 58,
                'province_id' => 7,
                'code' => '03',
                'name' => 'ATAHUALPA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 =>
            array (
                'id' => 59,
                'province_id' => 7,
                'code' => '04',
                'name' => 'BALSAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 =>
            array (
                'id' => 60,
                'province_id' => 7,
                'code' => '05',
                'name' => 'CHILLA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 =>
            array (
                'id' => 61,
                'province_id' => 7,
                'code' => '06',
                'name' => 'EL GUABO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 =>
            array (
                'id' => 62,
                'province_id' => 7,
                'code' => '07',
                'name' => 'HUAQUILLAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 =>
            array (
                'id' => 63,
                'province_id' => 7,
                'code' => '08',
                'name' => 'MARCABELI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 =>
            array (
                'id' => 64,
                'province_id' => 7,
                'code' => '09',
                'name' => 'PASAJE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 =>
            array (
                'id' => 65,
                'province_id' => 7,
                'code' => '10',
                'name' => 'PIÑAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 =>
            array (
                'id' => 66,
                'province_id' => 7,
                'code' => '11',
                'name' => 'PORTOVELO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 =>
            array (
                'id' => 67,
                'province_id' => 7,
                'code' => '12',
                'name' => 'SANTA ROSA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 =>
            array (
                'id' => 68,
                'province_id' => 7,
                'code' => '13',
                'name' => 'ZARUMA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 =>
            array (
                'id' => 69,
                'province_id' => 7,
                'code' => '14',
                'name' => 'LAS LAJAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 =>
            array (
                'id' => 70,
                'province_id' => 8,
                'code' => '01',
                'name' => 'ESMERALDAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 =>
            array (
                'id' => 71,
                'province_id' => 8,
                'code' => '02',
                'name' => 'ELOY ALFARO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 =>
            array (
                'id' => 72,
                'province_id' => 8,
                'code' => '03',
                'name' => 'MUISNE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 =>
            array (
                'id' => 73,
                'province_id' => 8,
                'code' => '04',
                'name' => 'QUININDE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 =>
            array (
                'id' => 74,
                'province_id' => 8,
                'code' => '05',
                'name' => 'SAN LORENZO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 =>
            array (
                'id' => 75,
                'province_id' => 8,
                'code' => '06',
                'name' => 'ATACAMES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 =>
            array (
                'id' => 76,
                'province_id' => 8,
                'code' => '07',
                'name' => 'RIO VERDE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 =>
            array (
                'id' => 77,
                'province_id' => 8,
                'code' => '08',
                'name' => 'LA CONCORDIA',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 =>
            array (
                'id' => 78,
                'province_id' => 9,
                'code' => '01',
                'name' => 'GUAYAQUIL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 =>
            array (
                'id' => 79,
                'province_id' => 9,
                'code' => '02',
                'name' => 'ALFREDO BAQUERIZO MORENO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 =>
            array (
                'id' => 80,
                'province_id' => 9,
                'code' => '03',
                'name' => 'BALAO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 =>
            array (
                'id' => 81,
                'province_id' => 9,
                'code' => '04',
                'name' => 'BALZAR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 =>
            array (
                'id' => 82,
                'province_id' => 9,
                'code' => '05',
                'name' => 'COLIMES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 =>
            array (
                'id' => 83,
                'province_id' => 9,
                'code' => '06',
                'name' => 'DAULE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 =>
            array (
                'id' => 84,
                'province_id' => 9,
                'code' => '07',
                'name' => 'DURAN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 =>
            array (
                'id' => 85,
                'province_id' => 9,
                'code' => '08',
                'name' => 'EL EMPALME',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 =>
            array (
                'id' => 86,
                'province_id' => 9,
                'code' => '09',
                'name' => 'EL TRIUNFO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 =>
            array (
                'id' => 87,
                'province_id' => 9,
                'code' => '10',
                'name' => 'MILAGRO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 =>
            array (
                'id' => 88,
                'province_id' => 9,
                'code' => '11',
                'name' => 'NARANJAL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 =>
            array (
                'id' => 89,
                'province_id' => 9,
                'code' => '12',
                'name' => 'NARANJITO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 =>
            array (
                'id' => 90,
                'province_id' => 9,
                'code' => '13',
                'name' => 'PALESTINA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 =>
            array (
                'id' => 91,
                'province_id' => 9,
                'code' => '14',
                'name' => 'PEDRO CARBO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 =>
            array (
                'id' => 92,
                'province_id' => 9,
                'code' => '16',
                'name' => 'SAMBORONDÓN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 =>
            array (
                'id' => 93,
                'province_id' => 9,
                'code' => '18',
                'name' => 'SANTA LUCIA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 =>
            array (
                'id' => 94,
                'province_id' => 9,
                'code' => '19',
            'name' => 'SALITRE (URBINA JADO)',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 =>
            array (
                'id' => 95,
                'province_id' => 9,
                'code' => '20',
                'name' => 'YAGUACHI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 =>
            array (
                'id' => 96,
                'province_id' => 9,
                'code' => '21',
                'name' => 'PLAYAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 =>
            array (
                'id' => 97,
                'province_id' => 9,
                'code' => '22',
                'name' => 'SIMON BOLIVAR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 =>
            array (
                'id' => 98,
                'province_id' => 9,
                'code' => '23',
                'name' => 'CORONEL MARCELINO MARIDUEÑA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 =>
            array (
                'id' => 99,
                'province_id' => 9,
                'code' => '24',
                'name' => 'LOMAS DE SARGENTILLO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 =>
            array (
                'id' => 100,
                'province_id' => 9,
                'code' => '25',
                'name' => 'NOBOL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 =>
            array (
                'id' => 101,
                'province_id' => 9,
                'code' => '27',
                'name' => 'GENERAL ANTONIO ELIZALDE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 =>
            array (
                'id' => 102,
                'province_id' => 9,
                'code' => '28',
                'name' => 'ISIDRO AYORA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 =>
            array (
                'id' => 103,
                'province_id' => 10,
                'code' => '01',
                'name' => 'IBARRA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 =>
            array (
                'id' => 104,
                'province_id' => 10,
                'code' => '02',
                'name' => 'ANTONIO ANTE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 =>
            array (
                'id' => 105,
                'province_id' => 10,
                'code' => '03',
                'name' => 'COTACACHI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 =>
            array (
                'id' => 106,
                'province_id' => 10,
                'code' => '04',
                'name' => 'OTAVALO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 =>
            array (
                'id' => 107,
                'province_id' => 10,
                'code' => '05',
                'name' => 'PIMAMPIRO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 =>
            array (
                'id' => 108,
                'province_id' => 10,
                'code' => '06',
                'name' => 'SAN MIGUEL DE URCUQUI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 =>
            array (
                'id' => 109,
                'province_id' => 11,
                'code' => '01',
                'name' => 'LOJA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 =>
            array (
                'id' => 110,
                'province_id' => 11,
                'code' => '02',
                'name' => 'CALVAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 =>
            array (
                'id' => 111,
                'province_id' => 11,
                'code' => '03',
                'name' => 'CATAMAYO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 =>
            array (
                'id' => 112,
                'province_id' => 11,
                'code' => '04',
                'name' => 'CELICA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 =>
            array (
                'id' => 113,
                'province_id' => 11,
                'code' => '05',
                'name' => 'CHAGUARPAMBA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 =>
            array (
                'id' => 114,
                'province_id' => 11,
                'code' => '06',
                'name' => 'ESPINDOLA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 =>
            array (
                'id' => 115,
                'province_id' => 11,
                'code' => '07',
                'name' => 'GONZANAMA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 =>
            array (
                'id' => 116,
                'province_id' => 11,
                'code' => '08',
                'name' => 'MACARA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 =>
            array (
                'id' => 117,
                'province_id' => 11,
                'code' => '09',
                'name' => 'PALTAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 =>
            array (
                'id' => 118,
                'province_id' => 11,
                'code' => '10',
                'name' => 'PUYANGO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 =>
            array (
                'id' => 119,
                'province_id' => 11,
                'code' => '11',
                'name' => 'SARAGURO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 =>
            array (
                'id' => 120,
                'province_id' => 11,
                'code' => '12',
                'name' => 'SOZORANGA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 =>
            array (
                'id' => 121,
                'province_id' => 11,
                'code' => '13',
                'name' => 'ZAPOTILLO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 =>
            array (
                'id' => 122,
                'province_id' => 11,
                'code' => '14',
                'name' => 'PINDAL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 =>
            array (
                'id' => 123,
                'province_id' => 11,
                'code' => '15',
                'name' => 'QUILANGA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 =>
            array (
                'id' => 124,
                'province_id' => 11,
                'code' => '16',
                'name' => 'OLMEDO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 =>
            array (
                'id' => 125,
                'province_id' => 12,
                'code' => '01',
                'name' => 'BABAHOYO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 =>
            array (
                'id' => 126,
                'province_id' => 12,
                'code' => '02',
                'name' => 'BABA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 =>
            array (
                'id' => 127,
                'province_id' => 12,
                'code' => '03',
                'name' => 'MONTALVO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 =>
            array (
                'id' => 128,
                'province_id' => 12,
                'code' => '04',
                'name' => 'PUEBLOVIEJO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 =>
            array (
                'id' => 129,
                'province_id' => 12,
                'code' => '05',
                'name' => 'QUEVEDO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 =>
            array (
                'id' => 130,
                'province_id' => 12,
                'code' => '06',
                'name' => 'URDANETA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 =>
            array (
                'id' => 131,
                'province_id' => 12,
                'code' => '07',
                'name' => 'VENTANAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 =>
            array (
                'id' => 132,
                'province_id' => 12,
                'code' => '08',
                'name' => 'VINCES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 =>
            array (
                'id' => 133,
                'province_id' => 12,
                'code' => '09',
                'name' => 'PALENQUE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 =>
            array (
                'id' => 134,
                'province_id' => 12,
                'code' => '10',
                'name' => 'BUENA FE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 =>
            array (
                'id' => 135,
                'province_id' => 12,
                'code' => '11',
                'name' => 'VALENCIA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 =>
            array (
                'id' => 136,
                'province_id' => 12,
                'code' => '12',
                'name' => 'MOCACHE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 =>
            array (
                'id' => 137,
                'province_id' => 12,
                'code' => '13',
                'name' => 'QUINSALOMA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 =>
            array (
                'id' => 138,
                'province_id' => 13,
                'code' => '01',
                'name' => 'PORTOVIEJO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 =>
            array (
                'id' => 139,
                'province_id' => 13,
                'code' => '02',
                'name' => 'BOLIVAR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 =>
            array (
                'id' => 140,
                'province_id' => 13,
                'code' => '03',
                'name' => 'CHONE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 =>
            array (
                'id' => 141,
                'province_id' => 13,
                'code' => '04',
                'name' => 'EL CARMEN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 =>
            array (
                'id' => 142,
                'province_id' => 13,
                'code' => '05',
                'name' => 'FLAVIO ALFARO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 =>
            array (
                'id' => 143,
                'province_id' => 13,
                'code' => '06',
                'name' => 'JIPIJAPA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 =>
            array (
                'id' => 144,
                'province_id' => 13,
                'code' => '07',
                'name' => 'JUNIN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 =>
            array (
                'id' => 145,
                'province_id' => 13,
                'code' => '08',
                'name' => 'MANTA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 =>
            array (
                'id' => 146,
                'province_id' => 13,
                'code' => '09',
                'name' => 'MONTECRISTI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 =>
            array (
                'id' => 147,
                'province_id' => 13,
                'code' => '10',
                'name' => 'PAJAN',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 =>
            array (
                'id' => 148,
                'province_id' => 13,
                'code' => '11',
                'name' => 'PICHINCHA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 =>
            array (
                'id' => 149,
                'province_id' => 13,
                'code' => '12',
                'name' => 'ROCAFUERTE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 =>
            array (
                'id' => 150,
                'province_id' => 13,
                'code' => '13',
                'name' => 'SANTA ANA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 =>
            array (
                'id' => 151,
                'province_id' => 13,
                'code' => '14',
                'name' => 'SUCRE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 =>
            array (
                'id' => 152,
                'province_id' => 13,
                'code' => '15',
                'name' => 'TOSAGUA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 =>
            array (
                'id' => 153,
                'province_id' => 13,
                'code' => '16',
                'name' => '24 DE MAYO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 =>
            array (
                'id' => 154,
                'province_id' => 13,
                'code' => '17',
                'name' => 'PEDERNALES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 =>
            array (
                'id' => 155,
                'province_id' => 13,
                'code' => '18',
                'name' => 'OLMEDO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 =>
            array (
                'id' => 156,
                'province_id' => 13,
                'code' => '19',
                'name' => 'PUERTO LOPEZ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 =>
            array (
                'id' => 157,
                'province_id' => 13,
                'code' => '20',
                'name' => 'JAMA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 =>
            array (
                'id' => 158,
                'province_id' => 13,
                'code' => '21',
                'name' => 'JARAMIJO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 =>
            array (
                'id' => 159,
                'province_id' => 13,
                'code' => '22',
                'name' => 'SAN VICENTE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 =>
            array (
                'id' => 160,
                'province_id' => 14,
                'code' => '01',
                'name' => 'MORONA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 =>
            array (
                'id' => 161,
                'province_id' => 14,
                'code' => '02',
                'name' => 'GUALAQUIZA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 =>
            array (
                'id' => 162,
                'province_id' => 14,
                'code' => '03',
                'name' => 'LIMON INDANZA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 =>
            array (
                'id' => 163,
                'province_id' => 14,
                'code' => '04',
                'name' => 'PALORA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 =>
            array (
                'id' => 164,
                'province_id' => 14,
                'code' => '05',
                'name' => 'SANTIAGO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 =>
            array (
                'id' => 165,
                'province_id' => 14,
                'code' => '06',
                'name' => 'SUCUA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 =>
            array (
                'id' => 166,
                'province_id' => 14,
                'code' => '07',
                'name' => 'HUAMBOYA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 =>
            array (
                'id' => 167,
                'province_id' => 14,
                'code' => '08',
                'name' => 'SAN JUAN  BOSCO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 =>
            array (
                'id' => 168,
                'province_id' => 14,
                'code' => '09',
                'name' => 'TAISHA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 =>
            array (
                'id' => 169,
                'province_id' => 14,
                'code' => '10',
                'name' => 'LOGROÑO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 =>
            array (
                'id' => 170,
                'province_id' => 14,
                'code' => '11',
                'name' => 'PALORA',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 =>
            array (
                'id' => 171,
                'province_id' => 14,
                'code' => '12',
                'name' => 'TIWINTZA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 =>
            array (
                'id' => 172,
                'province_id' => 14,
                'code' => '13',
                'name' => 'PABLO SEXTO',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 =>
            array (
                'id' => 173,
                'province_id' => 14,
                'code' => '14',
                'name' => 'TIWINTZA',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 =>
            array (
                'id' => 174,
                'province_id' => 15,
                'code' => '01',
                'name' => 'TENA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 =>
            array (
                'id' => 175,
                'province_id' => 15,
                'code' => '03',
                'name' => 'ARCHIDONA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 =>
            array (
                'id' => 176,
                'province_id' => 15,
                'code' => '04',
                'name' => 'EL CHACO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 =>
            array (
                'id' => 177,
                'province_id' => 15,
                'code' => '07',
                'name' => 'QUIJOS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 =>
            array (
                'id' => 178,
                'province_id' => 15,
                'code' => '09',
                'name' => 'CARLOS JULIO AROSEMENA TOLA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 =>
            array (
                'id' => 179,
                'province_id' => 16,
                'code' => '01',
                'name' => 'PASTAZA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 =>
            array (
                'id' => 180,
                'province_id' => 16,
                'code' => '02',
                'name' => 'MERA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 =>
            array (
                'id' => 181,
                'province_id' => 16,
                'code' => '03',
                'name' => 'SANTA CLARA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 =>
            array (
                'id' => 182,
                'province_id' => 16,
                'code' => '04',
                'name' => 'ARAJUNO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 =>
            array (
                'id' => 183,
                'province_id' => 17,
                'code' => '01',
                'name' => 'QUITO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 =>
            array (
                'id' => 184,
                'province_id' => 17,
                'code' => '02',
                'name' => 'CAYAMBE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 =>
            array (
                'id' => 185,
                'province_id' => 17,
                'code' => '03',
                'name' => 'MEJIA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 =>
            array (
                'id' => 186,
                'province_id' => 17,
                'code' => '04',
                'name' => 'PEDRO MONCAYO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 =>
            array (
                'id' => 187,
                'province_id' => 17,
                'code' => '05',
                'name' => 'RUMIÑAHUI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 =>
            array (
                'id' => 188,
                'province_id' => 17,
                'code' => '06',
                'name' => 'SANTO DOMINGO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 =>
            array (
                'id' => 189,
                'province_id' => 17,
                'code' => '07',
                'name' => 'SAN MIGUEL DE LOS BANCOS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 =>
            array (
                'id' => 190,
                'province_id' => 17,
                'code' => '08',
                'name' => 'PEDRO VICENTE MALDONADO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 =>
            array (
                'id' => 191,
                'province_id' => 17,
                'code' => '09',
                'name' => 'PUERTO QUITO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 =>
            array (
                'id' => 192,
                'province_id' => 18,
                'code' => '01',
                'name' => 'AMBATO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 =>
            array (
                'id' => 193,
                'province_id' => 18,
                'code' => '02',
                'name' => 'BAÑOS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 =>
            array (
                'id' => 194,
                'province_id' => 18,
                'code' => '03',
                'name' => 'CEVALLOS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 =>
            array (
                'id' => 195,
                'province_id' => 18,
                'code' => '04',
                'name' => 'MOCHA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 =>
            array (
                'id' => 196,
                'province_id' => 18,
                'code' => '05',
                'name' => 'PATATE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 =>
            array (
                'id' => 197,
                'province_id' => 18,
                'code' => '06',
                'name' => 'QUERO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 =>
            array (
                'id' => 198,
                'province_id' => 18,
                'code' => '07',
                'name' => 'SAN PEDRO DE PELILEO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 =>
            array (
                'id' => 199,
                'province_id' => 18,
                'code' => '08',
                'name' => 'SANTIAGO DE PILLARO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 =>
            array (
                'id' => 200,
                'province_id' => 18,
                'code' => '09',
                'name' => 'TISALEO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 =>
            array (
                'id' => 201,
                'province_id' => 19,
                'code' => '01',
                'name' => 'ZAMORA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 =>
            array (
                'id' => 202,
                'province_id' => 19,
                'code' => '02',
                'name' => 'CHINCHIPE',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 =>
            array (
                'id' => 203,
                'province_id' => 19,
                'code' => '03',
                'name' => 'NANGARITZA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 =>
            array (
                'id' => 204,
                'province_id' => 19,
                'code' => '04',
                'name' => 'YACUAMBI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 =>
            array (
                'id' => 205,
                'province_id' => 19,
                'code' => '05',
                'name' => 'YANTZAZA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 =>
            array (
                'id' => 206,
                'province_id' => 19,
                'code' => '06',
                'name' => 'EL PANGUI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 =>
            array (
                'id' => 207,
                'province_id' => 19,
                'code' => '07',
                'name' => 'CENTINELA DEL CONDOR',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 =>
            array (
                'id' => 208,
                'province_id' => 19,
                'code' => '08',
                'name' => 'PALANDA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 =>
            array (
                'id' => 209,
                'province_id' => 19,
                'code' => '09',
                'name' => 'PAQUISHA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 =>
            array (
                'id' => 210,
                'province_id' => 20,
                'code' => '01',
                'name' => 'SAN CRISTÓBAL',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 =>
            array (
                'id' => 211,
                'province_id' => 20,
                'code' => '02',
                'name' => 'ISABELA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 =>
            array (
                'id' => 212,
                'province_id' => 20,
                'code' => '03',
                'name' => 'SANTA CRUZ',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 =>
            array (
                'id' => 213,
                'province_id' => 21,
                'code' => '01',
                'name' => 'LAGO AGRIO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 =>
            array (
                'id' => 214,
                'province_id' => 21,
                'code' => '02',
                'name' => 'GONZALO PIZARRO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 =>
            array (
                'id' => 215,
                'province_id' => 21,
                'code' => '03',
                'name' => 'PUTUMAYO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 =>
            array (
                'id' => 216,
                'province_id' => 21,
                'code' => '04',
                'name' => 'SHUSHUFINDI',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 =>
            array (
                'id' => 217,
                'province_id' => 21,
                'code' => '05',
                'name' => 'SUCUMBIOS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 =>
            array (
                'id' => 218,
                'province_id' => 21,
                'code' => '06',
                'name' => 'CASCALES',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 =>
            array (
                'id' => 219,
                'province_id' => 21,
                'code' => '07',
                'name' => 'CUYABENO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 =>
            array (
                'id' => 220,
                'province_id' => 21,
                'code' => '08',
                'name' => 'LAGO AGRIO',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 =>
            array (
                'id' => 221,
                'province_id' => 21,
                'code' => '09',
                'name' => 'LUMBAQUI',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 =>
            array (
                'id' => 222,
                'province_id' => 21,
                'code' => '10',
                'name' => 'REVENTADOR',
                'status' => 'INACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 =>
            array (
                'id' => 223,
                'province_id' => 22,
                'code' => '01',
                'name' => 'FRANCISCO DE ORELLANA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 =>
            array (
                'id' => 224,
                'province_id' => 22,
                'code' => '02',
                'name' => 'AGUARICO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 =>
            array (
                'id' => 225,
                'province_id' => 22,
                'code' => '03',
                'name' => 'LA JOYA DE LOS SACHAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 =>
            array (
                'id' => 226,
                'province_id' => 22,
                'code' => '04',
                'name' => 'LORETO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 =>
            array (
                'id' => 227,
                'province_id' => 23,
                'code' => '01',
                'name' => 'SANTO DOMINGO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 =>
            array (
                'id' => 228,
                'province_id' => 24,
                'code' => '01',
                'name' => 'SANTA ELENA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 =>
            array (
                'id' => 229,
                'province_id' => 24,
                'code' => '02',
                'name' => 'LA LIBERTAD',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 =>
            array (
                'id' => 230,
                'province_id' => 24,
                'code' => '03',
                'name' => 'SALINAS',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 =>
            array (
                'id' => 231,
                'province_id' => 23,
                'code' => '02',
                'name' => 'LA CONCORDIA',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 =>
            array (
                'id' => 232,
                'province_id' => 14,
                'code' => '11',
                'name' => 'PABLO SEXTO',
                'status' => 'ACTIVO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
