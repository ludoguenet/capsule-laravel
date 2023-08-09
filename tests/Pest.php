<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

function login(
    User $user = null,
    Role $role = null,
) {
    $user ??= User::factory()->create();

    if ($role) {
        $user->assignRole($role);
    }

    return test()->actingAs($user);
}
