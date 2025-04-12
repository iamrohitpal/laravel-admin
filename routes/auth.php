<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'loginForm')->name('login');
    Route::post('logincheck', 'logincheck')->name('logincheck');
    Route::post('forgot-password', 'forgot_password')->name('forgot_password');
});
