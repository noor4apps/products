<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user-information', [AuthController::class, 'userInformation']);
        Route::post('update-user-information', [AuthController::class, 'updateUserInformation']);
        Route::post('change-password', [AuthController::class, 'changePassword']);

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
