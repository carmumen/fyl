<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylTrainingTeamTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_training_team')->delete();

        DB::table('fyl_training_team')->insert(array (
            0 =>
            array (
                'id' => 1,
                'training_id' => 1,
                'program' => 'Focus',
                'rol' => '2',
                'member_DNI' => '5584285253',
                'user_id' => 1,
                'created_at' => '2023-08-01 02:48:34',
                'updated_at' => '2023-08-01 02:48:34',
            ),
            1 =>
            array (
                'id' => 2,
                'training_id' => 1,
                'program' => 'Your',
                'rol' => '2',
                'member_DNI' => '6145237084',
                'user_id' => 1,
                'created_at' => '2023-08-01 02:48:51',
                'updated_at' => '2023-08-01 02:48:51',
            ),
            2 =>
            array (
                'id' => 4,
                'training_id' => 4,
                'program' => 'Focus',
                'rol' => '1',
                'member_DNI' => '1664821811',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:22:00',
                'updated_at' => '2023-08-04 01:22:00',
            ),
            3 =>
            array (
                'id' => 5,
                'training_id' => 4,
                'program' => 'Focus',
                'rol' => '2',
                'member_DNI' => '6145237084',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:22:06',
                'updated_at' => '2023-08-04 01:22:06',
            ),
            4 =>
            array (
                'id' => 6,
                'training_id' => 4,
                'program' => 'Focus',
                'rol' => '3',
                'member_DNI' => '4329209157',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:22:23',
                'updated_at' => '2023-08-04 01:22:23',
            ),
            5 =>
            array (
                'id' => 7,
                'training_id' => 4,
                'program' => 'Focus',
                'rol' => '1',
                'member_DNI' => '8387170394',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:22:37',
                'updated_at' => '2023-08-04 01:22:37',
            ),
            6 =>
            array (
                'id' => 8,
                'training_id' => 4,
                'program' => 'Your',
                'rol' => '2',
                'member_DNI' => '6145237084',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:22:50',
                'updated_at' => '2023-08-04 01:22:50',
            ),
            7 =>
            array (
                'id' => 9,
                'training_id' => 4,
                'program' => 'Your',
                'rol' => '4',
                'member_DNI' => '1347065502',
                'user_id' => 1,
                'created_at' => '2023-08-04 01:22:55',
                'updated_at' => '2023-08-04 01:22:55',
            ),
        ));


    }
}
