<?php

use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\UserProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'is_admin']], function () {

    Route::resource('users', UserController::class);

    Route::resource('products', ProductController::class);

    Route::resource('users.products', UserProductController::class);

});
