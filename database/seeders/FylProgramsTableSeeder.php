<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylProgramsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_programs')->delete();

        DB::table('fyl_programs')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'MettaTeems',
                'life_stage' => 24,
                'level' => '1',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Focus',
                'life_stage' => 25,
                'level' => '1',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Your',
                'life_stage' => 25,
                'level' => '2',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Life',
                'life_stage' => 25,
                'level' => '3',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
        ));


    }
}
