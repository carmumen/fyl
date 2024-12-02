<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylTrainingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_training')->delete();

        DB::table('fyl_training')->insert(array (
            0 =>
            array (
                'id' => 1,
                'campus_id' => 1,
                'number' => 79,
                'start_date_focus' => '2023-04-21',
                'end_date_focus' => '2023-04-23',
                'start_date_your' => '2023-05-05',
                'end_date_your' => '2023-05-07',
                'team_name' => 'Angeles de Fuego',
                'team_motto' => 'Aqui y Ahora',
                'team_directory' => NULL,
                'team_photo' => NULL,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 02:48:16',
                'updated_at' => '2023-08-13 00:40:41',
            ),
            1 =>
            array (
                'id' => 2,
                'campus_id' => 1,
                'number' => 80,
                'start_date_focus' => '2023-06-02',
                'end_date_focus' => '2023-06-04',
                'start_date_your' => '2023-06-16',
                'end_date_your' => '2023-06-18',
                'team_name' => 'Quimera 80',
                'team_motto' => 'Aqui y Ahora',
                'team_directory' => NULL,
                'team_photo' => NULL,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 03:15:31',
                'updated_at' => '2023-08-13 00:45:11',
            ),
            2 =>
            array (
                'id' => 3,
                'campus_id' => 1,
                'number' => 81,
                'start_date_focus' => '2023-07-07',
                'end_date_focus' => '2023-07-09',
                'start_date_your' => '2023-07-21',
                'end_date_your' => '2023-07-23',
                'team_name' => 'Halcones Dorados',
                'team_motto' => 'Aqui y Ahora',
                'team_directory' => NULL,
                'team_photo' => NULL,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 03:18:02',
                'updated_at' => '2023-08-13 00:45:38',
            ),
            3 =>
            array (
                'id' => 4,
                'campus_id' => 1,
                'number' => 82,
                'start_date_focus' => '2023-08-11',
                'end_date_focus' => '2023-08-13',
                'start_date_your' => '2023-08-25',
                'end_date_your' => '2023-08-27',
                'team_name' => NULL,
                'team_motto' => NULL,
                'team_directory' => NULL,
                'team_photo' => NULL,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:21:33',
                'updated_at' => '2023-08-31 15:44:42',
            ),
            4 =>
            array (
                'id' => 5,
                'campus_id' => 1,
                'number' => 83,
                'start_date_focus' => '2023-09-15',
                'end_date_focus' => '2023-09-17',
                'start_date_your' => '2023-09-29',
                'end_date_your' => '2023-10-01',
                'team_name' => NULL,
                'team_motto' => NULL,
                'team_directory' => NULL,
                'team_photo' => 'default.png',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-13 02:45:55',
                'updated_at' => '2023-08-31 15:45:43',
            ),
            5 =>
            array (
                'id' => 6,
                'campus_id' => 1,
                'number' => 84,
                'start_date_focus' => '2023-10-13',
                'end_date_focus' => '2023-10-15',
                'start_date_your' => '2023-10-27',
                'end_date_your' => '2023-10-29',
                'team_name' => NULL,
                'team_motto' => NULL,
                'team_directory' => NULL,
                'team_photo' => 'default.png',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:46:39',
                'updated_at' => '2023-08-31 15:47:15',
            ),
            6 =>
            array (
                'id' => 7,
                'campus_id' => 1,
                'number' => 85,
                'start_date_focus' => '2023-11-24',
                'end_date_focus' => '2023-11-26',
                'start_date_your' => '2023-12-08',
                'end_date_your' => '2023-12-10',
                'team_name' => NULL,
                'team_motto' => NULL,
                'team_directory' => NULL,
                'team_photo' => 'default.png',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:50:25',
                'updated_at' => '2023-08-31 15:51:06',
            ),
        ));


    }
}
