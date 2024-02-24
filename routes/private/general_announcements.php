<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('general_announcements/filter/{related?}',[\App\Http\Controllers\GeneralAnnouncementsController::class, 'experimental_filter']);
    Route::get('general_announcements/related/{related?}', [\App\Http\Controllers\GeneralAnnouncementsController::class,'index']);
    Route::get('general_announcements/{id}/{related?}', [\App\Http\Controllers\GeneralAnnouncementsController::class,'show']);
    Route::resource('general_announcements', \App\Http\Controllers\GeneralAnnouncementsController::class);
});


