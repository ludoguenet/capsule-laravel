<?php

declare(strict_types=1);

use App\Actions\StudentCard\GeneratePdf;
use App\Enums\SchoolEnum;
use App\Models\StudentCard;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\RoleSeeder;
use Mockery\MockInterface;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\post;
use Spatie\Permission\Models\Role;

beforeEach(
    fn () => $this->seed(RoleSeeder::class),
);

it('can store a student card as super admin or teacher', function (string $role) {
    \Pest\Laravel\mock(GeneratePdf::class, function (MockInterface $mock) {
        $mock->shouldReceive('handle')->once();
    });

    login(
        user: User::factory()->create()->assignRole(Role::firstWhere('name', $role)),
    );

    post(
        uri: route('student-cards.store'),
        data: [
            'user_id' => $userId = User::factory()->create()->id,
            'school' => $school = fake()->randomElement(SchoolEnum::cases())->value,
            'description' => $description = Str::random(16),
            'is_internal' => $isInternal = fake()->boolean,
            'date_of_birth' => $dob = Carbon::create('2000', '1', '1')->format('Y-m-d'),
        ]
    )->assertRedirectToRoute('dashboard');

    assertDatabaseCount('student_cards', 1);

    $studentCard = StudentCard::first();

    expect($studentCard->user_id)->toBe($userId);
    expect($studentCard->school->value)->toBe($school);
    expect($studentCard->description)->toBe($description);
    expect($studentCard->is_internal)->toBe($isInternal);
    expect($studentCard->date_of_birth->format('Y-m-d'))->toBe($dob);
})
    ->with([
        'teacher',
        'Super Admin',
    ]);

it('can not store a student card as student', function (string $role) {
    login(
        user: User::factory()->create()->assignRole(Role::firstWhere('name', $role)),
    );

    post(
        uri: route('student-cards.store'),
        data: [
            'user_id' => $userId = User::factory()->create()->id,
            'school' => $school = fake()->randomElement(SchoolEnum::cases())->value,
            'description' => $description = Str::random(16),
            'is_internal' => $isInternal = fake()->boolean,
            'date_of_birth' => $dob = Carbon::create('2000', '1', '1')->format('Y-m-d'),
        ]
    )->assertForbidden();
})
    ->with([
        'student',
    ]);

it('can not store a student card', function () {
    login(
        user: User::factory()->create()->assignRole(Role::firstWhere('name', 'teacher')),
    );

    post(
        uri: route('student-cards.store'),
        data: [
            'description' => $description = Str::random(2),
            'date_of_birth' => $dob = Carbon::create('2000', '1', '1')->format('d-m-Y'),
        ]
    )->assertSessionHasErrors([
        'user_id',
        'school',
        'description',
        'date_of_birth',
    ]);

    assertDatabaseCount('student_cards', 0);
});
