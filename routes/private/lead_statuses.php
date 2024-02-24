<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('lead_statuses/filter/{related?}',[\App\Http\Controllers\LeadStatusesController::class, 'experimental_filter']);
    Route::get('lead_statuses/related/{related?}', [\App\Http\Controllers\LeadStatusesController::class,'index']);
    Route::get('lead_statuses/{id}/{related?}', [\App\Http\Controllers\LeadStatusesController::class,'show']);
    Route::resource('lead_statuses', \App\Http\Controllers\LeadStatusesController::class);
});


