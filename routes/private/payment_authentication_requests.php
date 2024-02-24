<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::post('payment_authentication_requests/authorize_payment',[\App\Http\Controllers\PaymentAuthenticationRequestsController::class, 'authorize_payment']);
    Route::post('payment_authentication_requests/filter/{related?}',[\App\Http\Controllers\PaymentAuthenticationRequestsController::class, 'experimental_filter']);
    Route::get('payment_authentication_requests/related/{related?}', [\App\Http\Controllers\PaymentAuthenticationRequestsController::class,'index']);
    Route::get('payment_authentication_requests/{id}/{related?}', [\App\Http\Controllers\PaymentAuthenticationRequestsController::class,'show']);
    Route::resource('payment_authentication_requests', \App\Http\Controllers\PaymentAuthenticationRequestsController::class);
});
