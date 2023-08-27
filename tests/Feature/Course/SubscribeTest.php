<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('can subscribe to a course', function () {
    $course = Course::factory()->create();

    actingAs(User::factory()->create())
        ->put(
            route('subscribe', ['id' => $course->id])
        )
        ->assertOk()
        ->assertJsonStructure(['success', 'attached'])
        ->assertJson(
            fn (\Illuminate\Testing\Fluent\AssertableJson $json) => $json->where('attached', true)->etc(),
        );
});
