<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\StudentCard;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::factory(5)
            ->has(
                StudentCard::factory(),
            )
            ->create()
            ->each(
                fn (User $user) => $user->assignRole('student')
            );

        User::factory(5)
            ->create()
            ->each(
                fn (User $user) => $user->assignRole('teacher')
            );

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
        ])->assignRole('Super Admin');
    }
}
