<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->delete();

        DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Carlos Muñoz',
                'email' => 'cemm4@hotmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$aenwHtJdwcNKgbZoOzNmAu6cLzlyTV8d7sf7Kskl5E6iKvrMANJ8.',
                'state' => 'ACTIVE',
                'remember_token' => 'icKl3Xs31UmMnTQ9IO60tr9JOyvcdev39fIfp98sH0BbQDUcNE3Q5HltBB1c',
                'created_at' => '2023-03-06 02:12:02',
                'updated_at' => '2023-03-06 02:12:02',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Tannya',
                'email' => 'tves_24@hotmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$oRJDiwhO/dD6LmEaxdQYX.ziR2NMw.PwOxqxvPIGX8pqlIG.vLSSS',
                'state' => 'ACTIVE',
                'remember_token' => NULL,
                'created_at' => '2023-04-15 15:55:47',
                'updated_at' => '2023-04-15 15:55:47',
            ),
        ));


    }
}
