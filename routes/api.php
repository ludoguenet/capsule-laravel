<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(static function (): void {
    Route::get('events', \App\Http\Controllers\Api\Event\IndexController::class)->name('events');
    Route::put('subscribe', \App\Http\Controllers\Api\Course\SubscribeController::class)->name('subscribe');
});
