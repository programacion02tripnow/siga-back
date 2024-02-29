

<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('companies/filter/{related?}',[\App\Http\Controllers\CompanyController::class, 'experimental_filter']);
    Route::get('companies/related/{related?}', [\App\Http\Controllers\CompanyController::class,'index']);
    Route::get('companies/{id}/{related?}', [\App\Http\Controllers\CompanyController::class,'show']);
    Route::resource('companies', \App\Http\Controllers\CompanyController::class);
});


