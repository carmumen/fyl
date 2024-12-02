<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FylLifeTemplateTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('fyl_life_template')->delete();

        DB::table('fyl_life_template')->insert(array (
            0 =>
            array (
                'id' => 1,
            'activity' => '* 1FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'order' => 1,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:00:29',
                'updated_at' => '2023-08-01 01:00:29',
            ),
            1 =>
            array (
                'id' => 2,
                'activity' => 'Entrega de promesas formal al correo: fylcoordinacionuio@gmail.com',
                'order' => 2,
                'status' => 'INACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:00:45',
                'updated_at' => '2023-08-04 01:24:09',
            ),
            2 =>
            array (
                'id' => 3,
            'activity' => 'Reunión con coordinación de Life (vía zoom)',
                'order' => 3,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:00:58',
                'updated_at' => '2023-08-01 01:00:58',
            ),
            3 =>
            array (
                'id' => 4,
                'activity' => 'Entrega de Directorio. En formato digital y formato físico',
                'order' => 4,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:01:11',
                'updated_at' => '2023-08-01 01:01:11',
            ),
            4 =>
            array (
                'id' => 5,
                'activity' => 'Actividad CONFIANZA, Revisión de Promesas, Toma de foto inicial y Línea de abrazos',
                'order' => 5,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:01:23',
                'updated_at' => '2023-08-01 01:01:23',
            ),
            5 =>
            array (
                'id' => 6,
                'activity' => 'Paso de antorcha y Marcha de legendarios',
                'order' => 6,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:01:35',
                'updated_at' => '2023-08-01 01:01:35',
            ),
            6 =>
            array (
                'id' => 7,
                'activity' => 'Actividad TANQUE, Revisión de promesas, Vuelos',
                'order' => 7,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:01:46',
                'updated_at' => '2023-08-01 01:01:46',
            ),
            7 =>
            array (
                'id' => 8,
            'activity' => '* 2FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'order' => 8,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:02:01',
                'updated_at' => '2023-08-01 01:02:01',
            ),
            8 =>
            array (
                'id' => 9,
                'activity' => 'Susurros',
                'order' => 9,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:02:14',
                'updated_at' => '2023-08-01 01:02:14',
            ),
            9 =>
            array (
                'id' => 10,
                'activity' => 'Seguimiento de promesas y Línea de abrazos',
                'order' => 10,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:02:27',
                'updated_at' => '2023-08-01 01:02:27',
            ),
            10 =>
            array (
                'id' => 11,
                'activity' => 'Marcha de legendarios',
                'order' => 11,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:02:40',
                'updated_at' => '2023-08-01 01:02:40',
            ),
            11 =>
            array (
                'id' => 12,
                'activity' => 'Actividad ROMPIMIENTO DE BARRERAS, Seguimiento de Promesas, Vuelos',
                'order' => 12,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:02:57',
                'updated_at' => '2023-08-01 01:02:57',
            ),
            12 =>
            array (
                'id' => 13,
            'activity' => '* 3FDS (se requiere de todo el fin de semana para el entrenamiento)',
                'order' => 13,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:03:11',
                'updated_at' => '2023-08-01 01:03:24',
            ),
            13 =>
            array (
                'id' => 14,
                'activity' => 'Mezcla Intimar y Susurros',
                'order' => 14,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:03:38',
                'updated_at' => '2023-08-01 01:03:38',
            ),
            14 =>
            array (
                'id' => 15,
            'activity' => 'Revisión de promesas final, indicaciones para 4 FDS (vía zoom)',
                'order' => 15,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:03:48',
                'updated_at' => '2023-08-01 01:03:48',
            ),
            15 =>
            array (
                'id' => 16,
            'activity' => '* 4FDS (Bajo invitación, se requiere de todo el fin de semana para el entrenamiento)',
                'order' => 16,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:04:02',
                'updated_at' => '2023-08-01 01:04:02',
            ),
            16 =>
            array (
                'id' => 17,
                'activity' => 'Entrega de la foto oficial con los integrantes graduados',
                'order' => 17,
                'status' => 'ACTIVE',
                'user_id' => 1,
                'created_at' => '2023-08-01 01:04:14',
                'updated_at' => '2023-08-01 01:04:14',
            ),
        ));


    }
}
