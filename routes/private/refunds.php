<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::post('refunds/filter/{related?}',[\App\Http\Controllers\RefundsController::class, 'experimental_filter']);
    Route::get('refunds/related/{related?}', [\App\Http\Controllers\RefundsController::class,'index']);
    Route::get('refunds/{id}/{related?}', [\App\Http\Controllers\RefundsController::class,'show']);
    Route::resource('refunds', \App\Http\Controllers\RefundsController::class);
});
