<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('security_modules')->delete();

        DB::table('security_modules')->insert(array (
            0 =>
            array (
                'id' => 1,
                'parent' => 0,
                'name' => 'Administration',
                'order' => 1,
                'aplication_id' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-03-28 01:35:16',
                'updated_at' => '2023-04-04 22:52:39',
            ),
            1 =>
            array (
                'id' => 2,
                'parent' => 0,
                'name' => 'Administration',
                'order' => 1,
                'aplication_id' => 2,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-08 14:28:48',
                'updated_at' => '2023-04-16 13:03:23',
            ),
            2 =>
            array (
                'id' => 3,
                'parent' => 0,
                'name' => 'Administration',
                'order' => 1,
                'aplication_id' => 3,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-16 01:18:47',
                'updated_at' => '2023-04-16 01:20:31',
            ),
            3 =>
            array (
                'id' => 4,
                'parent' => 0,
                'name' => 'Administration',
                'order' => 1,
                'aplication_id' => 5,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:34:15',
                'updated_at' => '2023-05-15 00:34:15',
            ),
            4 =>
            array (
                'id' => 5,
                'parent' => 0,
                'name' => 'Administration',
                'order' => 1,
                'aplication_id' => 6,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:53:09',
                'updated_at' => '2023-05-20 19:53:09',
            ),
            5 =>
            array (
                'id' => 6,
                'parent' => 0,
                'name' => 'Administration',
                'order' => 1,
                'aplication_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:53:09',
                'updated_at' => '2023-05-20 19:53:09',
            ),
            6 =>
            array (
                'id' => 7,
                'parent' => 0,
                'name' => 'Oficina',
                'order' => 2,
                'aplication_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-07 02:50:24',
                'updated_at' => '2023-08-07 02:50:24',
            ),
            7 =>
            array (
                'id' => 8,
                'parent' => 0,
                'name' => 'Life',
                'order' => 5,
                'aplication_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-15 22:45:43',
                'updated_at' => '2023-08-18 01:16:08',
            ),
            8 =>
            array (
                'id' => 9,
                'parent' => 0,
                'name' => 'Focus',
                'order' => 3,
                'aplication_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-18 01:15:56',
                'updated_at' => '2023-08-18 01:15:56',
            ),
            9 =>
            array (
                'id' => 10,
                'parent' => 0,
                'name' => 'Your',
                'order' => 4,
                'aplication_id' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-08-18 01:16:25',
                'updated_at' => '2023-08-18 01:16:25',
            ),
        ));


    }
}
