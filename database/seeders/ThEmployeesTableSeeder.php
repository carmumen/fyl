<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThEmployeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('th_employees')->delete();

        DB::table('th_employees')->insert(array(
            0 =>
            array(
                'id' => 1,
                'DNI' => '8274651627',
                'names' => 'Dayna',
                'surnames' => 'Welch',
                'birthdate' => '2020-10-30',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '7053 Anna Points Suite 778 Keithside, IL 80573-5770',
                'phone' => '+12543198391',
                'email' => 'pollich.vita@hotmail.com',
                'status' => 'ACTIVE',
                'job_title_id' => 1,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'DNI' => '5584285253',
                'names' => 'Janelle',
                'surnames' => 'Jacobson',
                'birthdate' => '1971-08-26',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '3197 Ruecker Via
New Norwood, NC 51979-3988',
                'phone' => '628-285-2555',
                'email' => 'shyann46@hotmail.com',
                'status' => 'ACTIVE',
                'job_title_id' => 2,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'DNI' => '4329209157',
                'names' => 'Josianne',
                'surnames' => 'Huel',
                'birthdate' => '1970-12-06',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '684 Paul Ports
Tremayneshire, DE 03145',
                'phone' => '+12836717176',
                'email' => 'melvina.schoen@yahoo.com',
                'status' => 'ACTIVE',
                'job_title_id' => 3,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'DNI' => '1347065502',
                'names' => 'Rahsaan',
                'surnames' => 'Bruen',
                'birthdate' => '2004-12-21',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '324 Presley Islands Apt. 047
Walterton, CA 47782-0718',
                'phone' => '+1-661-248-6202',
                'email' => 'era72@weimann.net',
                'status' => 'ACTIVE',
                'job_title_id' => 4,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'DNI' => '8387170394',
                'names' => 'Ofelia',
                'surnames' => 'Johnston',
                'birthdate' => '2004-01-04',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '6653 Blick Isle Apt. 971
Gibsonton, ND 47199',
                'phone' => '+1 (469) 520-0760',
                'email' => 'xmante@yahoo.com',
                'status' => 'ACTIVE',
                'job_title_id' => 1,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'DNI' => '6145237084',
                'names' => 'Manley',
                'surnames' => 'Bernier',
                'birthdate' => '2019-11-26',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '7932 Schuppe Stravenue
Kleinmouth, CO 77176-5537',
                'phone' => '929.669.5847',
                'email' => 'xgrady@yahoo.com',
                'status' => 'ACTIVE',
                'job_title_id' => 2,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'DNI' => '5563191087',
                'names' => 'Burdette',
                'surnames' => 'Wintheiser',
                'birthdate' => '2005-02-09',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '3961 Becker Fields Apt. 578
Feestburgh, MS 09437',
                'phone' => '(574) 292-8310',
                'email' => 'adela80@robel.com',
                'status' => 'ACTIVE',
                'job_title_id' => 3,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'DNI' => '4753445701',
                'names' => 'Freida',
                'surnames' => 'Wolff',
                'birthdate' => '2001-03-20',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '186 Harvey Course Suite 809
Reingerville, HI 59423-2102',
                'phone' => '(541) 680-2660',
                'email' => 'pkeeling@abshire.biz',
                'status' => 'ACTIVE',
                'job_title_id' => 4,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array(
                'id' => 9,
                'DNI' => '1664821811',
                'names' => 'Destiney',
                'surnames' => 'Green',
                'birthdate' => '1982-07-29',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '673 Soledad Island
Jeffshire, NC 04049',
                'phone' => '937.380.0543',
                'email' => 'burnice.jaskolski@yahoo.com',
                'status' => 'ACTIVE',
                'job_title_id' => 1,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'DNI' => '663436824',
                'names' => 'Hector',
                'surnames' => 'Schulist',
                'birthdate' => '2000-12-30',
                'gender_catalog_id' => 1,
                'civil_status_catalog_id' => 1,
                'address' => '1715 Krista Groves
South Chloe, KY 84155',
                'phone' => '1-845-854-0112',
                'email' => 'jullrich@howe.info',
                'status' => 'ACTIVE',
                'job_title_id' => 1,
                'department_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
