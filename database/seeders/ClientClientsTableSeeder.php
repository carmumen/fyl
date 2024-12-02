<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ClientClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $names = $faker->firstName;
            DB::table('client_clients')->insert([
                'DNI' => $faker->randomNumber(9).$faker->randomDigit,
                'names' => $names,
                'surnames' => $faker->lastName,
                'nickname' => $names,
                'birthdate' => $faker->date,
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 3,
                'education_level_catalog_id' => 8,
                'address' => $faker->streetName,
                'mobile_phone' => $faker->e164PhoneNumber,
                'home_phone' => $faker->phoneNumber,
                'work_phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'status' => 'ACTIVE',
            ]);
        }
    }

  
}