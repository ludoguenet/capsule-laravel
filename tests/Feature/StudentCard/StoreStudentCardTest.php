<?php

declare(strict_types=1);

use App\Actions\StudentCard\GeneratePdf;
use App\Enums\SchoolEnum;
use App\Models\StudentCard;
use App\Models\User;
use Carbon\Carbon;
use Mockery\MockInterface;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

beforeEach(
    fn () => $this->seed(\Database\Seeders\RoleSeeder::class),
);

it('can store a student card for both teacher and super admin roles', function (App\Enums\RoleEnum $roleEnum) {
    \Pest\Laravel\mock(GeneratePdf::class, function (MockInterface $mock) {
        $mock->shouldReceive('handle')->once();
    });

    actingAs(User::factory()->create()->assignRole($roleEnum->value))
        ->post(
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
        \App\Enums\RoleEnum::SUPER_ADMIN,
        \App\Enums\RoleEnum::TEACHER,
    ]);

it('can store a student card for student role', function (App\Enums\RoleEnum $roleEnum) {
    actingAs(User::factory()->create()->assignRole($roleEnum->value))
        ->post(
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
        \App\Enums\RoleEnum::STUDENT,
    ]);

it('can not store a student card', function (App\Enums\RoleEnum $roleEnum) {
    actingAs(User::factory()->create()->assignRole($roleEnum->value))
        ->post(
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
})
    ->with([
        \App\Enums\RoleEnum::SUPER_ADMIN,
        \App\Enums\RoleEnum::TEACHER,
    ]);
