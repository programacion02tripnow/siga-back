<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('leads/create_customer', [\App\Http\Controllers\LeadsController::class, 'lead_to_customer']);
    Route::post('leads/create_comment', [\App\Http\Controllers\LeadsController::class, 'create_comment']);
    Route::post('leads/filter/{related?}', [\App\Http\Controllers\LeadsController::class, 'experimental_filter']);
    Route::get('leads/related/{related?}', [\App\Http\Controllers\LeadsController::class, 'index']);
    Route::get('leads/{id}/{related?}', [\App\Http\Controllers\LeadsController::class, 'show']);
    Route::post('leads/import_excel', [\App\Http\Controllers\LeadsController::class, 'import_from_excel']);

    Route::resource('leads', \App\Http\Controllers\LeadsController::class);
});


