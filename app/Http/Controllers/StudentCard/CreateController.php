<?php

declare(strict_types=1);

namespace App\Http\Controllers\StudentCard;

use App\Enums\SchoolEnum;
use App\Http\Controllers\Controller;
use App\Models\User;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('student_cards.create', [
            'users' => User::whereNot('id', auth()->id())->get(),
            'schools' => SchoolEnum::cases(),
        ]);
    }
}
