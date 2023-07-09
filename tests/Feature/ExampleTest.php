<?php

namespace Tests\Feature;

use function Pest\Laravel\get;

it('has a welcome page', function () {
    get('/')->assertOk();
});
