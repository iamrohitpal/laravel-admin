<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\GlobalController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('logout', 'logout')->name('logout');
    });

    // Global Routes
    Route::controller(GlobalController::class)->group(function () {
        // Delete Global Route
        Route::match(['get', 'post'], 'delete/{type}/{id}', 'delete_data')->name('delete_data');
    });

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::match(['get', 'post'], 'profile', 'profile')->name('profile');
        Route::match(['get', 'post'], 'change_password', 'change_password')->name('change_password');
        Route::match(['get', 'post'], 'update_profile', 'update_profile')->name('update_profile');

    });

    // category
    Route::controller(CategoryController::class)->group(function () {
        Route::match(['get', 'post'], 'category', 'category_list')->name('category_list');
        Route::match(['get', 'post'], 'category/{type}/{id}', 'category_form')->name('category_form');
        Route::match(['get', 'post'], 'save-category', 'save_category')->name('save_category');
    });

    // sub category
    Route::controller(SubCategoryController::class)->group(function () {
        Route::match(['get', 'post'], 'subcategory', 'subcategory_list')->name('subcategory_list');
        Route::match(['get', 'post'], 'subcategory/{type}/{id}', 'subcategory_form')->name('subcategory_form');
        Route::match(['get', 'post'], 'save-subcategorys', 'save_subcategory')->name('save_subcategory');
    });

    // product
    Route::controller(ProductController::class)->group(function () {
        Route::match(['get', 'post'], 'product', 'product_list')->name('product_list');
        Route::match(['get', 'post'], 'product/{type}/{id}', 'product_form')->name('product_form');
        Route::match(['get', 'post'], 'save-products', 'save_product')->name('save_product');
    });

    // blog
    Route::controller(BlogController::class)->group(function () {
        Route::match(['get', 'post'], 'blog', 'blog_list')->name('blog_list');
        Route::match(['get', 'post'], 'blog/{type}/{id}', 'blog_form')->name('blog_form');
        Route::match(['get', 'post'], 'save-blog', 'save_blog')->name('save_blog');
    });

    // seo
    Route::controller(SeoController::class)->group(function () {
        Route::match(['get', 'post'], 'seo', 'seo_list')->name('seo_list');
        Route::match(['get', 'post'], 'seo/{type}/{id}', 'seo_form')->name('seo_form');
        Route::match(['get', 'post'], 'save-seo', 'save_seo')->name('save_seo');
    });

    // enquiry
    Route::controller(EnquiryController::class)->group(function () {
        Route::match(['get', 'post'], 'enquiry-details', 'enquiry_list')->name('enquiry_list');
    });

    // role
    Route::controller(RoleController::class)->group(function () {
        Route::match(['get', 'post'], 'role', 'role_list')->name('role_list');
        Route::match(['get', 'post'], 'role/{type}/{id}', 'role_form')->name('role_form');
        Route::match(['get', 'post'], 'save-role', 'save_role')->name('save_role');
    });

    // user
    Route::controller(UserController::class)->group(function () {
        Route::match(['get', 'post'], 'user', 'user_list')->name('user_list');
        Route::match(['get', 'post'], 'user/{type}/{id}', 'user_form')->name('user_form');
        Route::match(['get', 'post'], 'save-user', 'save_user')->name('save_user');
    });
});
