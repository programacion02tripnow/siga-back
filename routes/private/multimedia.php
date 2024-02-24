<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::post('multimedia/filter/{related?}',[\App\Http\Controllers\MultimediaController::class, 'experimental_filter']);
    Route::get('multimedia/related/{related?}', [\App\Http\Controllers\MultimediaController::class,'index']);
    Route::get('multimedia/{id}/{related?}', [\App\Http\Controllers\MultimediaController::class,'show']);
    Route::resource('multimedia', \App\Http\Controllers\MultimediaController::class);
});
