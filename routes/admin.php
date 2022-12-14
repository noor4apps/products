<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'  =>  'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function () {
    Route::view('/', 'admin.index')->name('index');

    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('users.products', UserProductController::class);

});
