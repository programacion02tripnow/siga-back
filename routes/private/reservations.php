<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api'])->group(function () {
    Route::get('reservation/get-history/{reservation_id}', [\App\Http\Controllers\ReservationsController::class, 'get_logs']);
    Route::delete('reservations/cancel-service/{id}', [\App\Http\Controllers\ReservationsController::class, 'cancel_service']);
    Route::get('validate_refund/{token}', [\App\Http\Controllers\ReservationsController::class, 'validate_refund']);
    Route::post('reservations/save-reservation-detail-comment', [\App\Http\Controllers\ReservationsController::class, 'save_reservation_detail_comment']);
    Route::get('reservations/get-form-info/{id}', [\App\Http\Controllers\ReservationsController::class, 'get_form_info']);
    Route::post('reservations/create_comment', [\App\Http\Controllers\ReservationsController::class, 'create_comment']);
    Route::post('reservations/filter/{related?}',[\App\Http\Controllers\ReservationsController::class, 'experimental_filter']);
    Route::get('reservations/related/{related?}', [\App\Http\Controllers\ReservationsController::class,'index']);
    Route::get('reservations/{id}/{related?}', [\App\Http\Controllers\ReservationsController::class,'show']);
    Route::resource('reservations', \App\Http\Controllers\ReservationsController::class);
});

Route::post('reservations/report', [\App\Http\Controllers\ReservationsController::class, 'reservations_export']);
Route::post('commissions/report', [\App\Http\Controllers\ReservationsController::class, 'commissions_export']);
Route::post('user_commissions/report', [\App\Http\Controllers\ReservationsController::class, 'user_commissions_export']);



