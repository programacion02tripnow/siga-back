<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::post('customers/create_comment', [\App\Http\Controllers\CustomersController::class, 'create_comment']);
    Route::post('customers/filter/{related?}',[\App\Http\Controllers\CustomersController::class, 'experimental_filter']);
    Route::get('customers/related/{related?}', [\App\Http\Controllers\CustomersController::class,'index']);
    Route::get('customers/{id}/{related?}', [\App\Http\Controllers\CustomersController::class,'show']);
    Route::resource('customers', \App\Http\Controllers\CustomersController::class);    
});
