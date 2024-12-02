<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityUserProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('security_user_profiles')->delete();

        DB::table('security_user_profiles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 1,
                'profile_id' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-13 11:39:26',
                'updated_at' => '2023-04-15 12:16:27',
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => 2,
                'profile_id' => 3,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-15 15:55:55',
                'updated_at' => '2023-04-15 16:00:17',
            ),
            2 =>
            array (
                'id' => 3,
                'user_id' => 1,
                'profile_id' => 5,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-16 01:22:18',
                'updated_at' => '2023-04-16 01:25:21',
            ),
            3 =>
            array (
                'id' => 4,
                'user_id' => 1,
                'profile_id' => 3,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-30 23:53:20',
                'updated_at' => '2023-04-30 23:53:20',
            ),
            4 =>
            array (
                'id' => 5,
                'user_id' => 1,
                'profile_id' => 7,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-01 01:27:20',
                'updated_at' => '2023-05-01 01:27:20',
            ),
            5 =>
            array (
                'id' => 6,
                'user_id' => 1,
                'profile_id' => 8,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:42:51',
                'updated_at' => '2023-05-15 00:42:51',
            ),
            6 =>
            array (
                'id' => 7,
                'user_id' => 1,
                'profile_id' => 9,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:55:33',
                'updated_at' => '2023-05-20 19:55:33',
            ),
        ));


    }
}
