<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('logout', 'logout')->name('logout');

        // Profile
        Route::match(['get', 'post'], 'profile', 'profile')->name('profile');
        Route::match(['get', 'post'], 'change_password', 'change_password')->name('change_password');
        Route::match(['get', 'post'], 'update_profile', 'update_profile')->name('update_profile');

        // blog
        Route::match(['get', 'post'], 'blogs', 'blogs')->name('blog_list');
        Route::match(['get', 'post'], 'blog/{type}/{id}', 'blog_form')->name('blog_form');
        Route::match(['get', 'post'], 'save-blog', 'save_blog')->name('save_blog');

        // category
        Route::match(['get', 'post'], 'category', 'category_list')->name('category_list');
        Route::match(['get', 'post'], 'category/{type}/{id}', 'category_form')->name('category_form');
        Route::match(['get', 'post'], 'save-category', 'save_category')->name('save_category');

        //sub category
        Route::match(['get', 'post'], 'subcategory', 'subcategory_list')->name('subcategory_list');
        Route::match(['get', 'post'], 'subcategory/{type}/{id}', 'subcategory_form')->name('subcategory_form');
        Route::match(['get', 'post'], 'save-subcategorys', 'save_subcategory')->name('save_subcategory');

        // product            
        Route::match(['get', 'post'], 'product', 'product_list')->name('product_list');
        Route::match(['get', 'post'], 'product/{type}/{id}', 'product_form')->name('product_form');
        Route::match(['get', 'post'], 'save-products', 'save_product')->name('save_product');

        // enquiry
        Route::match(['get', 'post'], 'enquiry-details', 'enquiry_list')->name('enquiry_list');

        // // Delete Global Route
        Route::match(['get', 'post'], 'delete/{type}/{id}', 'delete_data')->name('delete_data');
    });
    
    Route::controller(RoleController::class)->group(function () {    
        // role            
        Route::match(['get', 'post'], 'role', 'role_list')->name('role_list');
        Route::match(['get', 'post'], 'role/{type}/{id}', 'role_form')->name('role_form');
        Route::match(['get', 'post'], 'save-role', 'save_role')->name('save_role');
    });

    Route::controller(UserController::class)->group(function () {    
        // user            
        Route::match(['get', 'post'], 'user', 'user_list')->name('user_list');
        Route::match(['get', 'post'], 'user/{type}/{id}', 'user_form')->name('user_form');
        Route::match(['get', 'post'], 'save-user', 'save_user')->name('save_user');
    });
});