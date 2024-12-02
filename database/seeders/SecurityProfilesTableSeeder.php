<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('security_profiles')->delete();

        DB::table('security_profiles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Super Administrador',
                'aplication_id' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-03-31 00:15:59',
                'updated_at' => '2023-03-31 00:18:24',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Administrador',
                'aplication_id' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-03-31 00:16:12',
                'updated_at' => '2023-03-31 00:16:12',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Super Administrador',
                'aplication_id' => 2,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-08 14:29:37',
                'updated_at' => '2023-04-16 13:07:10',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Administrador',
                'aplication_id' => 2,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-08 15:09:24',
                'updated_at' => '2023-04-16 13:07:19',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Administrator',
                'aplication_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-16 01:21:27',
                'updated_at' => '2023-04-16 01:21:27',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Coordinador',
                'aplication_id' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-30 23:45:11',
                'updated_at' => '2023-08-05 17:16:16',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Administrador',
                'aplication_id' => 3,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-01 01:27:00',
                'updated_at' => '2023-05-01 01:27:00',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Administrator',
                'aplication_id' => 5,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:42:16',
                'updated_at' => '2023-05-15 00:42:16',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Administrator',
                'aplication_id' => 6,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:54:57',
                'updated_at' => '2023-05-20 19:54:57',
            ),
        ));


    }
}
