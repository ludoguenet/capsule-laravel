<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('can retrieve courses', function () {
    Course::factory(5)->create();

    actingAs(User::factory()->create())
        ->get(
            route('events')
        )
        ->assertOk()
        ->assertJsonStructure(['events'])
        ->assertJson(
            fn (\Illuminate\Testing\Fluent\AssertableJson $json) => $json->where('events.0.id', 1)->etc(),
        );
});
