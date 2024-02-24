<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', function () {
    return json_encode(["message" => "Unauthenticated."]);
})->name('login');

Route::post('login',  [\App\Http\Controllers\UsersController::class, 'login']);

foreach (glob(base_path('/routes/private/*.php')) as $filename) {
    include_once $filename;
}
