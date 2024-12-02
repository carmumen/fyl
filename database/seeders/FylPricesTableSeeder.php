<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylPricesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_prices')->delete();

        DB::table('fyl_prices')->insert(array (
            0 =>
            array (
                'id' => 1,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus',
                'programs_included' => 'F',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 71,
                'price' => '270.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:02:04',
                'updated_at' => '2023-08-31 11:36:05',
            ),
            1 =>
            array (
                'id' => 2,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus',
                'programs_included' => 'F',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 70,
                'price' => '215.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:05:04',
                'updated_at' => '2023-08-31 11:36:15',
            ),
            2 =>
            array (
                'id' => 3,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus',
                'programs_included' => 'F',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 72,
                'price' => '0.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:06:05',
                'updated_at' => '2023-08-31 11:36:42',
            ),
            3 =>
            array (
                'id' => 4,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your + Life',
                'programs_included' => 'FYL',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 70,
                'price' => '846.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:09:09',
                'updated_at' => '2023-08-31 11:40:04',
            ),
            4 =>
            array (
                'id' => 5,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your',
                'programs_included' => 'FY',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 70,
                'price' => '546.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:09:57',
                'updated_at' => '2023-08-31 11:35:46',
            ),
            5 =>
            array (
                'id' => 6,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your + Life',
                'programs_included' => 'FYL',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '1410.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:11:47',
                'updated_at' => '2023-08-31 11:40:13',
            ),
            6 =>
            array (
                'id' => 7,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your',
                'programs_included' => 'FY',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '910.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:12:32',
                'updated_at' => '2023-08-31 11:35:25',
            ),
            7 =>
            array (
                'id' => 8,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus',
                'programs_included' => 'F',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '360.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-07 02:20:58',
                'updated_at' => '2023-08-31 11:35:55',
            ),
            8 =>
            array (
                'id' => 11,
                'campus_id' => 1,
                'program_id' => 3,
                'description' => 'Your + Life',
                'programs_included' => 'YL',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '787.50',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 10:43:23',
                'updated_at' => '2023-08-31 11:37:08',
            ),
            9 =>
            array (
                'id' => 12,
                'campus_id' => 1,
                'program_id' => 3,
                'description' => 'Your',
                'programs_included' => 'Y',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '412.50',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 10:45:37',
                'updated_at' => '2023-08-31 11:37:27',
            ),
            10 =>
            array (
                'id' => 13,
                'campus_id' => 1,
                'program_id' => 3,
                'description' => 'Your',
                'programs_included' => 'Y',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 72,
                'price' => '0.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 10:46:31',
                'updated_at' => '2023-08-31 11:37:38',
            ),
            11 =>
            array (
                'id' => 14,
                'campus_id' => 1,
                'program_id' => 3,
                'description' => 'Your + Life',
                'programs_included' => 'YL',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 72,
                'price' => '0.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 10:48:27',
                'updated_at' => '2023-08-31 11:37:21',
            ),
            12 =>
            array (
                'id' => 15,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your',
                'programs_included' => 'FY',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 72,
                'price' => '0.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 10:54:09',
                'updated_at' => '2023-08-31 11:36:29',
            ),
            13 =>
            array (
                'id' => 16,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your + Life',
                'programs_included' => 'FYL',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 72,
                'price' => '0.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 10:54:55',
                'updated_at' => '2023-08-31 11:36:52',
            ),
            14 =>
            array (
                'id' => 17,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your',
                'programs_included' => 'FY',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 71,
                'price' => '637.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 11:41:00',
                'updated_at' => '2023-08-31 11:41:00',
            ),
            15 =>
            array (
                'id' => 18,
                'campus_id' => 1,
                'program_id' => 2,
                'description' => 'Focus + Your + Life',
                'programs_included' => 'FYL',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 71,
                'price' => '987.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 11:41:40',
                'updated_at' => '2023-08-31 11:41:40',
            ),
            16 =>
            array (
                'id' => 19,
                'campus_id' => 1,
                'program_id' => 4,
                'description' => 'Viernes',
                'programs_included' => 'L',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '375.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 11:49:45',
                'updated_at' => '2023-08-31 11:49:45',
            ),
            17 =>
            array (
                'id' => 20,
                'campus_id' => 1,
                'program_id' => 4,
                'description' => 'Sábado',
                'programs_included' => 'L',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '422.50',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 11:50:36',
                'updated_at' => '2023-08-31 11:50:36',
            ),
            18 =>
            array (
                'id' => 21,
                'campus_id' => 1,
                'program_id' => 4,
                'description' => 'Domingo Mañana',
                'programs_included' => 'L',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '480.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 11:51:11',
                'updated_at' => '2023-08-31 11:51:11',
            ),
            19 =>
            array (
                'id' => 22,
                'campus_id' => 1,
                'program_id' => 4,
                'description' => 'Domingo Tarde',
                'programs_included' => 'L',
                'catalogo_id_currency' => 49,
                'catalogo_id_price_type' => 69,
                'price' => '525.00',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 11:51:46',
                'updated_at' => '2023-08-31 11:51:46',
            ),
        ));


    }
}
