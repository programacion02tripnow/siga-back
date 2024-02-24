<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('reservation_comments/filter/{related?}',[\App\Http\Controllers\ReservationCommentsController::class, 'experimental_filter']);
    Route::get('reservation_comments/related/{related?}', [\App\Http\Controllers\ReservationCommentsController::class,'index']);
    Route::get('reservation_comments/{id}/{related?}', [\App\Http\Controllers\ReservationCommentsController::class,'show']);
    Route::resource('reservation_comments', \App\Http\Controllers\ReservationCommentsController::class);
});


