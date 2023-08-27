<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $courseIds = auth()->user()->courses()->pluck('id');

        $events = Course::all()
            ->map(function (Course $course) use ($courseIds): array {
                return [
                    'id' => $courseId = $course->id,
                    'title' => $course->title,
                    'color' => $course->colour,
                    'start' => $course->starts_at->format('Y-m-d H:i:s'),
                    'end' => $course->ends_at->format('Y-m-d H:i:s'),
                    'borderColor' => $courseIds->contains($courseId) ? 'green' : 'yellow',
                ];
            });

        return response()->json([
            'events' => $events,
        ]);
    }
}
