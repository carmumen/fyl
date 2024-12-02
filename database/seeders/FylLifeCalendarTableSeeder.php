<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylLifeCalendarTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_life_calendar')->delete();

        DB::table('fyl_life_calendar')->insert(array (
            0 =>
            array (
                'id' => 9,
                'training_id' => 1,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-04-14',
                'end_date' => '2023-04-16',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:40:42',
                'updated_at' => '2023-08-31 15:40:42',
            ),
            1 =>
            array (
                'id' => 10,
                'training_id' => 2,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-06-23',
                'end_date' => '2023-06-25',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:42:00',
                'updated_at' => '2023-08-31 15:42:00',
            ),
            2 =>
            array (
                'id' => 11,
                'training_id' => 3,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-07-28',
                'end_date' => '2023-07-30',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:42:56',
                'updated_at' => '2023-08-31 15:42:56',
            ),
            3 =>
            array (
                'id' => 12,
                'training_id' => 4,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-09-01',
                'end_date' => '2023-09-03',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:45:11',
                'updated_at' => '2023-08-31 15:45:11',
            ),
            4 =>
            array (
                'id' => 13,
                'training_id' => 5,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-10-06',
                'end_date' => '2023-10-08',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:46:14',
                'updated_at' => '2023-08-31 15:46:14',
            ),
            5 =>
            array (
                'id' => 14,
                'training_id' => 6,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-11-10',
                'end_date' => '2023-11-12',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:47:44',
                'updated_at' => '2023-08-31 15:47:44',
            ),
            6 =>
            array (
                'id' => 15,
                'training_id' => 7,
                'life_template_id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'start_date' => '2023-12-15',
                'end_date' => '2023-12-17',
                'start_hour' => '18:00:00',
                'end_hour' => '22:00:00',
                'user_id' => 1,
                'created_at' => '2023-08-31 15:51:33',
                'updated_at' => '2023-08-31 15:51:33',
            ),
        ));


    }
}
