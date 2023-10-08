<?php

declare(strict_types=1);

namespace App\Http\Controllers\StudentCard;

use App\Actions\StudentCard\GeneratePdf;
use App\DataObjects\MoneyDTO;
use App\DataObjects\StudentCardDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCard\StoreRequest;
use App\Models\StudentCard;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __invoke(
        StoreRequest $request,
    ): RedirectResponse {
        $studentCardDTO = new StudentCardDTO(
            user_id: $request->validated()['user_id'],
            school: $request->validated()['school'],
            description: $request->validated()['description'] ?? null,
            canteen_price: new MoneyDTO($request->validated()['canteen_price']),
            is_internal: $request->validated()['is_internal'],
            date_of_birth: $request->validated()['date_of_birth'],
        );

        app(GeneratePdf::class)->handle(
            card: StudentCard::create(
                $studentCardDTO->toArray(),
            ),
            directory: config('student-cards.pdf.directory'),
        );

        return redirect()->route('dashboard');
    }
}
