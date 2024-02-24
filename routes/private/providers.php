<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('providers/filter/{related?}',[\App\Http\Controllers\ProvidersController::class, 'experimental_filter']);
    Route::get('providers/related/{related?}', [\App\Http\Controllers\ProvidersController::class,'index']);
    Route::get('providers/{id}/{related?}', [\App\Http\Controllers\ProvidersController::class,'show']);
    Route::resource('providers', \App\Http\Controllers\ProvidersController::class);
});


