<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::post('reservation_payments/filter/{related?}',[\App\Http\Controllers\ReservationPaymentsController::class, 'experimental_filter']);
    Route::get('reservation_payments/related/{related?}', [\App\Http\Controllers\ReservationPaymentsController::class,'index']);
    Route::get('reservation_payments/{id}/{related?}', [\App\Http\Controllers\ReservationPaymentsController::class,'show']);
    Route::resource('reservation_payments', \App\Http\Controllers\ReservationPaymentsController::class);
});
