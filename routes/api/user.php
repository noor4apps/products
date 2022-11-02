<?php

use App\Http\Controllers\Api\User\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {

    Route::group(['prefix' => 'products', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [ProductController::class, 'index']);
    });

});
