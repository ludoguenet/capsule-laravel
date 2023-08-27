<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::factory(3)
            ->sequence(
                [
                    'starts_at' => now()->setTime(9, 0),
                    'ends_at' => now()->setTime(10, 0),
                ],
                [
                    'starts_at' => now()->setTime(10, 0),
                    'ends_at' => now()->setTime(11, 0),
                ],
                [
                    'starts_at' => now()->setTime(14, 0),
                    'ends_at' => now()->setTime(16, 0),
                ],
            )
            ->create();
    }
}
