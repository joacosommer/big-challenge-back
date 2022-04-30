<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\User;
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
        User::factory(10)->create();
        Submission::factory(10)->pending()->create();
        Submission::factory(10)->inProgress()->create();
        Submission::factory(10)->done()->create();
    }
}
