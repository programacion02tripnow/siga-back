<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('mail/welcome', function(){
    $r = \App\Models\Customer::first();
    return new \App\Mail\Welcome($r);
});
Route::get('mail/confirmation', function(){
    $r = \App\Models\Reservation::first();
    return new \App\Mail\ReservationConfirmation($r);
});
Route::get('mail/pending', function(){
    $r = \App\Models\Reservation::first();
    return new \App\Mail\PendingPayment($r);
});

Route::get('generate_pdf/{id}', [\App\Http\Controllers\ReservationsController::class, 'voucher']);



Route::get('/{any}', [\App\Http\Controllers\ApplicationController::class, 'index'])->where('any', '.*');

