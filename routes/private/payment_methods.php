<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::post('payment_methods/filter/{related?}',[\App\Http\Controllers\PaymentMethodsController::class, 'experimental_filter']);
    Route::get('payment_methods/related/{related?}', [\App\Http\Controllers\PaymentMethodsController::class,'index']);
    Route::get('payment_methods/{id}/{related?}', [\App\Http\Controllers\PaymentMethodsController::class,'show']);
    Route::resource('payment_methods', \App\Http\Controllers\PaymentMethodsController::class);
});
