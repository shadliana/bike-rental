<?php

use App\Http\Controllers\BikeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/bikes', [BikeController::class, 'index']);
    Route::post('/bikes', [BikeController::class, 'create']);
    Route::put('/bikes/{bike}', [BikeController::class, 'update']);
    Route::delete('/bikes/{bike}', [BikeController::class, 'delete']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'create']);
    Route::delete('/reservations/{reservation}', [BikeController::class, 'delete']);
});
