<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role2 = Role::create(['name' => 'patient']);
        $role3 = Role::create(['name' => 'doctor']);

        $permission2 = Permission::create(['name' => 'patient_permission']);
        $permission3 = Permission::create(['name' => 'doctor_permission']);

        $role2->givePermissionTo($permission2);
        $role3->givePermissionTo($permission3);
    }
}
