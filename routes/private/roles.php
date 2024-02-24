<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('roles/filter/{related?}',[\App\Http\Controllers\RolesController::class, 'experimental_filter']);
    Route::get('roles/related/{related?}', [\App\Http\Controllers\RolesController::class,'index']);
    Route::get('roles/{id}/{related?}', [\App\Http\Controllers\RolesController::class,'show']);
    Route::resource('roles', \App\Http\Controllers\RolesController::class);
});


