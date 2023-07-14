<?php

declare(strict_types=1);

namespace App\Http\Controllers\StudentCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCard\StoreRequest;
use App\Models\StudentCard;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(
        StoreRequest $request,
    ) {
        dd(StudentCard::create($request->validated()));
    }
}
