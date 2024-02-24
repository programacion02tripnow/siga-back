<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    //Route::get('auth_settlement/{settlement_id}/{auth_token}', [\App\Http\Controllers\SettlementsController::class, '']);
    Route::post('settlements/create_comment', [\App\Http\Controllers\SettlementsController::class, 'create_comment']);
    Route::post('settlements/filter/{related?}',[\App\Http\Controllers\SettlementsController::class, 'experimental_filter']);
    Route::get('settlements/related/{related?}', [\App\Http\Controllers\SettlementsController::class,'index']);
    Route::get('settlements/{id}/{related?}', [\App\Http\Controllers\SettlementsController::class,'show']);
    Route::resource('settlements', \App\Http\Controllers\SettlementsController::class);
});
