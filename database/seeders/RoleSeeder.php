<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'student',
        ]);

        Role::create([
            'name' => 'Super Admin',
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher',
        ]);

        (Permission::create(['name' => 'student-cards.*']))->assignRole($teacherRole);
    }
}
