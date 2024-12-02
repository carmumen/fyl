<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ThJobTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('th_job_title')->delete();

        DB::table('th_job_title')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Coordinador',
                'description' => 'Team',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Couch',
                'description' => 'Team',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Couch en formación',
                'description' => 'Team',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Legendario',
                'description' => 'Team',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Administrador',
                'description' => 'M',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Chofer',
                'description' => 'M',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Director',
                'description' => 'M',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Jefe Operativo',
                'description' => 'M',
                'minimum_salary' => 100,
                'maximum_salary' => 300,
                'status' => 'ACTIVE',
            ),
        ));


    }
}
