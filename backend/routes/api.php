<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::post('/', [EventController::class, 'store']);
    Route::post('/{id}/register', [EventController::class, 'register']);
    Route::get('/{id}/attendees',    [EventController::class, 'attendees']);

});
