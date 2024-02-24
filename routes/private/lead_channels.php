<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('lead_channels/filter/{related?}',[\App\Http\Controllers\LeadChannelsController::class, 'experimental_filter']);
    Route::get('lead_channels/related/{related?}', [\App\Http\Controllers\LeadChannelsController::class,'index']);
    Route::get('lead_channels/{id}/{related?}', [\App\Http\Controllers\LeadChannelsController::class,'show']);
    Route::resource('lead_channels', \App\Http\Controllers\LeadChannelsController::class);
});


