<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityProfileFunctionalitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('security_profile_functionalities')->delete();

        DB::table('security_profile_functionalities')->insert(array (
            0 =>
            array (
                'id' => 1,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-04 12:04:24',
                'updated_at' => '2023-04-12 11:14:47',
            ),
            1 =>
            array (
                'id' => 2,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 2,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-15 12:13:03',
                'updated_at' => '2023-04-15 12:13:03',
            ),
            2 =>
            array (
                'id' => 3,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 3,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-15 12:13:20',
                'updated_at' => '2023-04-15 12:13:20',
            ),
            3 =>
            array (
                'id' => 4,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-15 12:13:34',
                'updated_at' => '2023-04-15 12:13:34',
            ),
            4 =>
            array (
                'id' => 5,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 5,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-15 15:56:39',
                'updated_at' => '2023-04-15 15:56:39',
            ),
            5 =>
            array (
                'id' => 6,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 7,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-16 01:24:59',
                'updated_at' => '2023-04-16 01:24:59',
            ),
            6 =>
            array (
                'id' => 7,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 8,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-30 23:45:35',
                'updated_at' => '2023-04-30 23:45:35',
            ),
            7 =>
            array (
                'id' => 8,
                'aplication_id' => 1,
                'profile_id' => 1,
                'functionality_id' => 8,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-30 23:50:18',
                'updated_at' => '2023-04-30 23:50:18',
            ),
            8 =>
            array (
                'id' => 9,
                'aplication_id' => 3,
                'profile_id' => 7,
                'functionality_id' => 9,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-01 01:27:11',
                'updated_at' => '2023-05-01 01:27:11',
            ),
            9 =>
            array (
                'id' => 10,
                'aplication_id' => 3,
                'profile_id' => 7,
                'functionality_id' => 10,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-14 15:33:14',
                'updated_at' => '2023-05-14 15:33:14',
            ),
            10 =>
            array (
                'id' => 11,
                'aplication_id' => 3,
                'profile_id' => 7,
                'functionality_id' => 11,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-14 18:06:29',
                'updated_at' => '2023-05-14 18:06:29',
            ),
            11 =>
            array (
                'id' => 12,
                'aplication_id' => 5,
                'profile_id' => 8,
                'functionality_id' => 12,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:42:28',
                'updated_at' => '2023-05-15 00:42:28',
            ),
            12 =>
            array (
                'id' => 13,
                'aplication_id' => 5,
                'profile_id' => 8,
                'functionality_id' => 13,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:42:37',
                'updated_at' => '2023-05-15 00:42:37',
            ),
            13 =>
            array (
                'id' => 14,
                'aplication_id' => 3,
                'profile_id' => 7,
                'functionality_id' => 14,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-16 19:07:58',
                'updated_at' => '2023-05-16 19:07:58',
            ),
            14 =>
            array (
                'id' => 15,
                'aplication_id' => 6,
                'profile_id' => 9,
                'functionality_id' => 15,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:55:08',
                'updated_at' => '2023-05-20 19:55:08',
            ),
            15 =>
            array (
                'id' => 16,
                'aplication_id' => 6,
                'profile_id' => 9,
                'functionality_id' => 16,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:55:16',
                'updated_at' => '2023-05-20 19:55:16',
            ),
            16 =>
            array (
                'id' => 17,
                'aplication_id' => 5,
                'profile_id' => 8,
                'functionality_id' => 17,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-21 21:47:27',
                'updated_at' => '2023-05-21 21:47:27',
            ),
            17 =>
            array (
                'id' => 18,
                'aplication_id' => 3,
                'profile_id' => 7,
                'functionality_id' => 18,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-21 21:56:49',
                'updated_at' => '2023-05-21 21:56:49',
            ),
            18 =>
            array (
                'id' => 19,
                'aplication_id' => 5,
                'profile_id' => 8,
                'functionality_id' => 19,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-22 22:15:26',
                'updated_at' => '2023-05-22 22:15:26',
            ),
            19 =>
            array (
                'id' => 20,
                'aplication_id' => 5,
                'profile_id' => 8,
                'functionality_id' => 20,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            20 =>
            array (
                'id' => 21,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 21,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            21 =>
            array (
                'id' => 22,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 22,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            22 =>
            array (
                'id' => 23,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 23,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            23 =>
            array (
                'id' => 24,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 23,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            24 =>
            array (
                'id' => 25,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 24,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            25 =>
            array (
                'id' => 26,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 25,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:14',
                'updated_at' => '2023-05-23 10:09:14',
            ),
            26 =>
            array (
                'id' => 27,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 26,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-11 18:31:24',
                'updated_at' => '2023-08-11 18:31:24',
            ),
            27 =>
            array (
                'id' => 28,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 28,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-13 17:24:19',
                'updated_at' => '2023-08-13 17:24:19',
            ),
            28 =>
            array (
                'id' => 29,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 29,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-15 22:50:22',
                'updated_at' => '2023-08-15 22:50:22',
            ),
            29 =>
            array (
                'id' => 30,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 30,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-15 22:50:22',
                'updated_at' => '2023-08-15 22:50:22',
            ),
            30 =>
            array (
                'id' => 31,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 33,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-15 22:50:22',
                'updated_at' => '2023-08-15 22:50:22',
            ),
            31 =>
            array (
                'id' => 32,
                'aplication_id' => 4,
                'profile_id' => 5,
                'functionality_id' => 35,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-15 22:50:22',
                'updated_at' => '2023-08-15 22:50:22',
            ),
        ));


    }
}
