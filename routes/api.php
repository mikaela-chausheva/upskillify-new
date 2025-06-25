<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;

Route::middleware('auth')->group(function () {
    Route::get('/courses/{id}/messages', [MessageController::class, 'index']);
    Route::post('/courses/{id}/messages', [MessageController::class, 'store']);
});
