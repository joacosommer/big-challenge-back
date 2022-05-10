<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        $admin = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'date_of_birth' => '2020-01-01',
            'gender' => 'male',
            'phone_number' => '0000000',
            'address' => 'Montevideo',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        $admin->assignRole('admin');
        $admin->save();

//        $this->call(RoleSeeder::class);
        User::factory(5)->patient()->create();
        User::factory(2)->doctor()->create();
        Submission::factory(10)->pending()->create();
        Submission::factory(10)->inProgress()->create();
        Submission::factory(10)->done()->create();
    }
}
