<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'  =>  'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function () {
    Route::view('/', 'admin.index')->name('index');

    Route::resource('products', ProductController::class);

});
