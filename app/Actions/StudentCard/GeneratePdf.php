<?php

declare(strict_types=1);

namespace App\Actions\StudentCard;

use App\Models\StudentCard;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GeneratePdf
{
    public function handle(
        StudentCard $card,
        string $directory,
    ): StudentCard {
        $card->load('user');

        $pdf = Pdf::loadView(config('student-cards.pdf.view'), ['card' => $card]);

        if (Storage::directoryMissing($directory)) {
            Storage::makeDirectory($directory);
        }

        $pdf->save($path = Storage::path($directory).DIRECTORY_SEPARATOR.$card->id.config('student-cards.pdf.extension'));

        $card
            ->addMedia($path)
            ->toMediaCollection('pdf');

        return $card->refresh();
    }
}
