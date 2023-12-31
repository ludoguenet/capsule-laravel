<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('calendar', 'calendar')->name('calendar');

    Route::prefix('student-cards')
        ->as('student-cards.')
        ->middleware('can:student-cards')
        ->group(static function (): void {
            Route::get('/create', \App\Http\Controllers\StudentCard\CreateController::class)->name('create');
            Route::post('/', \App\Http\Controllers\StudentCard\StoreController::class)->name('store');
        });
});

require __DIR__.'/auth.php';
