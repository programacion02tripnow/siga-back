<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::get('dashboard/info', [\App\Http\Controllers\DashboardController::class, 'dashboard']);
});
