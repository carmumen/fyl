<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThEmployeeDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('th_employee_details')->delete();

        DB::table('th_employee_details')->insert(array (
            0 =>
            array (
                'id' => 1,
                'employee_id' => 2,
                'evaluator' => 'NO',
                'job_title_id' => 2,
                'department_id' => 2,
                'entry_date' => '2023-05-01',
                'departure_date' => NULL,
                'comment' => NULL,
                'status' => 'ACTIVE',
                'created_at' => '2023-05-19 11:13:29',
                'updated_at' => '2023-05-19 11:13:29',
            ),
            1 =>
            array (
                'id' => 2,
                'employee_id' => 7,
                'evaluator' => 'NO',
                'job_title_id' => 3,
                'department_id' => 6,
                'entry_date' => '2023-05-19',
                'departure_date' => NULL,
                'comment' => NULL,
                'status' => 'ACTIVE',
                'created_at' => '2023-05-19 11:13:43',
                'updated_at' => '2023-05-19 11:13:43',
            ),
            2 =>
            array (
                'id' => 3,
                'employee_id' => 5,
                'evaluator' => 'NO',
                'job_title_id' => 8,
                'department_id' => 3,
                'entry_date' => '2023-05-01',
                'departure_date' => NULL,
                'comment' => NULL,
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 14:24:52',
                'updated_at' => '2023-05-20 14:24:52',
            ),
            3 =>
            array (
                'id' => 4,
                'employee_id' => 10,
                'evaluator' => 'NO',
                'job_title_id' => 3,
                'department_id' => 6,
                'entry_date' => '2023-05-01',
                'departure_date' => NULL,
                'comment' => NULL,
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 14:25:10',
                'updated_at' => '2023-05-20 14:25:10',
            ),
            4 =>
            array (
                'id' => 5,
                'employee_id' => 1,
                'evaluator' => 'NO',
                'job_title_id' => 6,
                'department_id' => 4,
                'entry_date' => '2023-05-01',
                'departure_date' => NULL,
                'comment' => NULL,
                'status' => 'ACTIVE',
                'created_at' => '2023-05-20 14:25:32',
                'updated_at' => '2023-05-20 14:25:32',
            ),
        ));


    }
}
