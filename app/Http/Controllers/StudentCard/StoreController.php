<?php

declare(strict_types=1);

namespace App\Http\Controllers\StudentCard;

use App\Actions\StudentCard\GeneratePdf;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCard\StoreRequest;
use App\Models\StudentCard;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __invoke(
        StoreRequest $request,
    ): RedirectResponse {
        app(GeneratePdf::class)->handle(
            card: StudentCard::create($request->validated()),
            directory: config('student-cards.pdf.directory'),
        );

        return redirect()->route('dashboard');
    }
}
