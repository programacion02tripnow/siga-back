<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('modules/filter/{related?}',[\App\Http\Controllers\ModulesController::class, 'experimental_filter']);
    Route::get('modules/related/{related?}', [\App\Http\Controllers\ModulesController::class,'index']);
    Route::get('modules/{id}/{related?}', [\App\Http\Controllers\ModulesController::class,'show']);
    Route::resource('modules', \App\Http\Controllers\ModulesController::class);
});


