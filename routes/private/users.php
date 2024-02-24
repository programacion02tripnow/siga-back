<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('users/with-permissions/{permission}', [\App\Http\Controllers\UsersController::class, 'get_users_has_permission']);
    Route::get('users/update-info',[\App\Http\Controllers\UsersController::class, 'get_user_info']);
    Route::post('users/filter/{related?}',[\App\Http\Controllers\UsersController::class, 'experimental_filter']);
    Route::get('users/related/{related?}', [\App\Http\Controllers\UsersController::class,'index']);
    Route::get('users/{id}/{related?}', [\App\Http\Controllers\UsersController::class,'show']);
    Route::resource('users', \App\Http\Controllers\UsersController::class);
});


