<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RoleEnum;
use App\Models\StudentCard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $teacherRole = Role::firstWhere('name', RoleEnum::TEACHER->value);

        User::factory(9)
            ->create()
            ->each(
                fn (User $user) => $user->assignRole($teacherRole),
            );

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
        ])
            ->assignRole(Role::firstWhere('name', RoleEnum::SUPER_ADMIN->value));

        $studentRole = Role::firstWhere('name', RoleEnum::STUDENT->value);

        User::factory(10)
            ->has(
                StudentCard::factory(),
            )
            ->create()
            ->each(
                fn (User $user) => $user->assignRole($studentRole),
            );
    }
}
