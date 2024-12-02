<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(SecurityAplicationsTableSeeder::class);
        $this->call(SecurityModulesTableSeeder::class);
        $this->call(SecurityFunctionalitiesTableSeeder::class);
        $this->call(SecurityProfilesTableSeeder::class);
        $this->call(SecurityProfileFunctionalitiesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SecurityUserProfilesTableSeeder::class);
        $this->call(GlobalCountriesTableSeeder::class);
        $this->call(GlobalProvincesTableSeeder::class);
        $this->call(GlobalCantonsTableSeeder::class);
        $this->call(GlobalCitiesTableSeeder::class);
        $this->call(GlobalCatalogTypesTableSeeder::class);
        $this->call(GlobalCatalogsTableSeeder::class);
        $this->call(ThDepartmentTableSeeder::class);
        $this->call(ThJobTitleTableSeeder::class);
        $this->call(ThEmployeesTableSeeder::class);
        $this->call(ClientClientsTableSeeder::class);
        $this->call(FylCampusTableSeeder::class);
        $this->call(FylProgramsTableSeeder::class);
        $this->call(FylTrainingTableSeeder::class);
        $this->call(FylLifeTemplateTableSeeder::class);
        $this->call(FylTrainingTeamTableSeeder::class);
        $this->call(FylLifeCalendarTableSeeder::class);
        $this->call(FylPricesTableSeeder::class);
        $this->call(FylParticipantsTableSeeder::class);
    }
}
