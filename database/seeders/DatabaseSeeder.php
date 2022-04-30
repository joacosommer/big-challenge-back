<?php

namespace Database\Seeders;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        PatientInformation::factory(10)->create();
        DoctorInformation::factory(10)->create();
    }
}
