<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylCampusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_campus')->delete();

        DB::table('fyl_campus')->insert(array (
            0 =>
            array (
                'id' => 1,
                'city_id' => 1000,
                'name' => 'Quito',
                'address' => 'De los Cedros OE1-13 y Real Audiencia',
                'phone' => '0995980294',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
            1 =>
            array (
                'id' => 2,
                'city_id' => 476,
                'name' => 'Guayaquil',
                'address' => 'Los Ceibos',
                'phone' => '0995980294',
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
        ));


    }
}
