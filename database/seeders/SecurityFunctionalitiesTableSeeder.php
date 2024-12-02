<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityFunctionalitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('security_functionalities')->delete();

        DB::table('security_functionalities')->insert(array (
            0 =>
            array (
                'id' => 1,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-library',
                'name' => 'Aplications',
                'order' => 1,
                'route' => 'Aplications.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-04-03 23:38:49',
                'updated_at' => '2023-04-07 13:36:40',
            ),
            1 =>
            array (
                'id' => 2,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-dice',
                'name' => 'Modules',
                'order' => 2,
                'route' => 'Modules.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-03-28 01:45:23',
                'updated_at' => '2023-04-05 11:15:41',
            ),
            2 =>
            array (
                'id' => 3,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-bullhorn',
                'name' => 'Functionalities',
                'order' => 3,
                'route' => 'Functionalities.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-03-28 01:43:34',
                'updated_at' => '2023-04-07 13:37:33',
            ),
            3 =>
            array (
                'id' => 4,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-user-check',
                'name' => 'Profiles',
                'order' => 4,
                'route' => 'Profiles.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-03-28 01:44:43',
                'updated_at' => '2023-04-07 13:36:57',
            ),
            4 =>
            array (
                'id' => 5,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-road',
                'name' => 'Profile Functionality',
                'order' => 5,
                'route' => 'ProfileFunctionalities.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-03-28 02:30:22',
                'updated_at' => '2023-04-07 13:37:06',
            ),
            5 =>
            array (
                'id' => 6,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-user-tie',
                'name' => 'User Profile',
                'order' => 7,
                'route' => 'UserProfiles.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-03-28 02:30:22',
                'updated_at' => '2023-04-07 13:37:06',
            ),
            6 =>
            array (
                'id' => 7,
                'aplication_id' => 1,
                'module_id' => 1,
                'icon' => 'icon-user',
                'name' => 'Users',
                'order' => 6,
                'route' => 'Users.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-04-30 23:43:59',
                'updated_at' => '2023-05-01 00:15:21',
            ),
            7 =>
            array (
                'id' => 8,
                'aplication_id' => 3,
                'module_id' => 3,
                'icon' => 'icon-accessibility',
                'name' => 'Empleados',
                'order' => 3,
                'route' => 'Employees.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-01 01:26:41',
                'updated_at' => '2023-05-15 23:03:17',
            ),
            8 =>
            array (
                'id' => 9,
                'aplication_id' => 3,
                'module_id' => 3,
                'icon' => 'icon-hammer2',
                'name' => 'Job Titles',
                'order' => 2,
                'route' => 'JobTitles.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-14 15:31:57',
                'updated_at' => '2023-05-14 18:08:06',
            ),
            9 =>
            array (
                'id' => 10,
                'aplication_id' => 3,
                'module_id' => 3,
                'icon' => 'icon-cogs',
                'name' => 'Departments',
                'order' => 1,
                'route' => 'Departments.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-14 18:06:12',
                'updated_at' => '2023-05-14 18:11:18',
            ),
            10 =>
            array (
                'id' => 11,
                'aplication_id' => 5,
                'module_id' => 4,
                'icon' => 'icon-cog',
                'name' => 'Catalog Type',
                'order' => 1,
                'route' => 'CatalogTypes.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:40:34',
                'updated_at' => '2023-05-15 01:26:07',
            ),
            11 =>
            array (
                'id' => 12,
                'aplication_id' => 5,
                'module_id' => 4,
                'icon' => 'icon-cogs',
                'name' => 'Catalogs',
                'order' => 2,
                'route' => 'Catalogs.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:41:23',
                'updated_at' => '2023-05-15 00:41:23',
            ),
            12 =>
            array (
                'id' => 14,
                'aplication_id' => 6,
                'module_id' => 5,
                'icon' => 'icon-users',
                'name' => 'Clients',
                'order' => 1,
                'route' => 'Clients.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:53:45',
                'updated_at' => '2023-05-20 19:53:45',
            ),
            13 =>
            array (
                'id' => 15,
                'aplication_id' => 6,
                'module_id' => 5,
                'icon' => 'icon-user-tie',
                'name' => 'Customer Details',
                'order' => 2,
                'route' => 'CustomerDetails.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-20 19:54:38',
                'updated_at' => '2023-05-20 19:54:38',
            ),
            14 =>
            array (
                'id' => 16,
                'aplication_id' => 5,
                'module_id' => 4,
                'icon' => 'icon-earth',
                'name' => 'Countries',
                'order' => 3,
                'route' => 'Countries.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-21 21:45:01',
                'updated_at' => '2023-05-21 21:45:01',
            ),
            15 =>
            array (
                'id' => 18,
                'aplication_id' => 5,
                'module_id' => 4,
                'icon' => 'icon-shirtsinbulk',
                'name' => 'Provinces',
                'order' => 4,
                'route' => 'Provinces.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-22 22:15:09',
                'updated_at' => '2023-05-22 22:15:09',
            ),
            16 =>
            array (
                'id' => 19,
                'aplication_id' => 5,
                'module_id' => 4,
                'icon' => 'icon-flag-o',
                'name' => 'Cantons',
                'order' => 5,
                'route' => 'Cantons.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-23 10:09:00',
                'updated_at' => '2023-05-23 10:09:00',
            ),
            17 =>
            array (
                'id' => 20,
                'aplication_id' => 5,
                'module_id' => 4,
                'icon' => 'icon-map-signs',
                'name' => 'Cities',
                'order' => 6,
                'route' => 'Cities.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-25 00:39:40',
                'updated_at' => '2023-05-25 00:39:40',
            ),
            18 =>
            array (
                'id' => 21,
                'aplication_id' => 4,
                'module_id' => 6,
                'icon' => 'icon-home',
                'name' => 'Sedes',
                'order' => 1,
                'route' => 'Campus.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-25 00:39:40',
                'updated_at' => '2023-05-25 00:39:40',
            ),
            19 =>
            array (
                'id' => 22,
                'aplication_id' => 4,
                'module_id' => 6,
                'icon' => 'icon-yelp',
                'name' => 'Programs',
                'order' => 2,
                'route' => 'Programs.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-25 00:39:40',
                'updated_at' => '2023-05-25 00:39:40',
            ),
            20 =>
            array (
                'id' => 23,
                'aplication_id' => 4,
                'module_id' => 7,
                'icon' => 'icon-steam',
                'name' => 'Training',
                'order' => 1,
                'route' => 'Training.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-25 00:39:40',
                'updated_at' => '2023-08-07 02:51:15',
            ),
            21 =>
            array (
                'id' => 24,
                'aplication_id' => 4,
                'module_id' => 7,
                'icon' => 'icon-profile',
                'name' => 'Participants',
                'order' => 2,
                'route' => 'Participants.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-25 00:39:40',
                'updated_at' => '2023-08-07 02:51:34',
            ),
            22 =>
            array (
                'id' => 25,
                'aplication_id' => 4,
                'module_id' => 6,
                'icon' => 'icon-insert-template',
                'name' => 'Life Template',
                'order' => 4,
                'route' => 'LifeTemplate.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-05-25 00:39:40',
                'updated_at' => '2023-08-07 02:51:54',
            ),
            23 =>
            array (
                'id' => 26,
                'aplication_id' => 4,
                'module_id' => 6,
                'icon' => 'icon-price-tag',
                'name' => 'Prices',
                'order' => 3,
                'route' => 'Prices.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-07 02:52:41',
                'updated_at' => '2023-08-07 02:54:10',
            ),
            24 =>
            array (
                'id' => 27,
                'aplication_id' => 4,
                'module_id' => 6,
                'icon' => 'icon-price-tag',
                'name' => 'Price',
                'order' => 3,
                'route' => 'Prices.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-11 18:31:03',
                'updated_at' => '2023-08-11 18:31:03',
            ),
            25 =>
            array (
                'id' => 28,
                'aplication_id' => 4,
                'module_id' => 7,
                'icon' => 'icon-users',
                'name' => 'Clients',
                'order' => 1,
                'route' => 'Clients.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-13 17:14:57',
                'updated_at' => '2023-08-13 17:14:57',
            ),
            26 =>
            array (
                'id' => 29,
                'aplication_id' => 4,
                'module_id' => 8,
                'icon' => 'icon-link',
                'name' => 'Enrollment link',
                'order' => 1,
                'route' => 'Enroller.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-15 22:49:57',
                'updated_at' => '2023-08-15 22:51:00',
            ),
            27 =>
            array (
                'id' => 30,
                'aplication_id' => 4,
                'module_id' => 9,
                'icon' => 'icon-users',
                'name' => 'Focus Participants',
                'order' => 1,
                'route' => 'FocusParticipants.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-18 01:34:59',
                'updated_at' => '2023-08-18 03:02:23',
            ),
            28 =>
            array (
                'id' => 31,
                'aplication_id' => 4,
                'module_id' => 10,
                'icon' => 'icon-users',
                'name' => 'Staff Your',
                'order' => 1,
                'route' => 'StaffYour.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-18 01:36:51',
                'updated_at' => '2023-08-18 01:43:13',
            ),
            29 =>
            array (
                'id' => 33,
                'aplication_id' => 4,
                'module_id' => 7,
                'icon' => 'icon-users',
                'name' => 'Staff',
                'order' => 4,
                'route' => 'StaffFocus.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-18 01:40:46',
                'updated_at' => '2023-08-27 19:01:32',
            ),
            30 =>
            array (
                'id' => 34,
                'aplication_id' => 4,
                'module_id' => 9,
                'icon' => 'icon-users',
                'name' => 'Participantes',
                'order' => 1,
                'route' => 'FocusParticipants.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-27 17:01:38',
                'updated_at' => '2023-08-27 17:01:38',
            ),
            31 =>
            array (
                'id' => 35,
                'aplication_id' => 4,
                'module_id' => 9,
                'icon' => 'icon-users',
                'name' => 'Team Focus',
                'order' => 2,
                'route' => 'TeamStaff.index',
                'state' => 'ACTIVE',
                'created_at' => '2023-08-27 19:13:21',
                'updated_at' => '2023-08-27 23:54:11',
            ),
        ));


    }
}
