<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->doctor()->create([
            'email' => 'sommer@gmail.com',
            'password' => Hash::make('123456'),
        ]);
//        $this->call(RoleSeeder::class);
        User::factory(5)->patient()->create();
        User::factory(2)->doctor()->create();
        Submission::factory(10)->pending()->create();
        Submission::factory(10)->inProgress()->create();
        Submission::factory(10)->done()->create();
    }
}
