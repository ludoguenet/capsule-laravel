<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = auth()->user()->courses()->toggle($request->id);

        return response()->json([
            'success' => true,
            'attached' => ! empty($result['attached']),
        ]);
    }
}
