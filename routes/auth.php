<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'loginForm')->name('login');
    Route::post('logincheck', 'logincheck')->name('logincheck');
    Route::post('forgot-password', 'forgot_password')->name('forgot_password');
});