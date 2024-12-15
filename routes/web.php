<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;


Route::get('/', [WebController::class, 'index'])->name('admin');

Route::controller(AuthController::class)->group(function () {
    Route::get('admin/login', 'loginForm')->name('login');
    Route::post('admin/logincheck', 'logincheck')->name('logincheck');
    Route::post('admin/forgot-password', 'forgot_password')->name('forgot_password');
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'dashboard')->name('dashboard');
        Route::prefix('admin')->group(function () {
            Route::get('logout', 'logout')->name('logout');
            Route::match(['get', 'post'], 'change_password', 'change_password')->name('change_password');
            Route::match(['get', 'post'], 'update_profile', 'update_profile')->name('update_profile');
            Route::match(['get', 'post'], 'blogs', 'blogs')->name('blog_list');
            Route::match(['get', 'post'], 'blog/{type}/{id}', 'blog_form')->name('blog_form');
            Route::match(['get', 'post'], '{type}-blog', 'save_blog')->name('save_blog');
            Route::match(['get', 'post'], 'blog-detailview/{id}', 'blog_details')->name('blog_details');


            Route::match(['get', 'post'], 'contact-us', 'contactus_list')->name('contactus_list');
            Route::match(['get', 'post'], 'contactus-details/{form_type}/{id}', 'contactus_form')->name('contactus_form');
            Route::match(['get', 'post'], '{type}-contactus', 'save_contactus')->name('save_contactus');
            Route::match(['get', 'post'], 'contactus-detailview/{id}', 'contactus_details')->name('contactus_details');

            Route::match(['get', 'post'], 'gallery', 'gallery_list')->name('gallery_list');
            Route::match(['get', 'post'], 'gallery/{type}/{id}', 'gallery_form')->name('gallery_form');
            Route::match(['get', 'post'], '{type}-gallery', 'save_gallery')->name('save_gallery');
            Route::match(['get', 'post'], 'gallery-detailview/{id}', 'gallery_details')->name('gallery_details');

            Route::match(['get', 'post'], 'about-us', 'aboutus_list')->name('aboutus_list');
            Route::match(['get', 'post'], 'about-us/{type}/{id}', 'aboutus_form')->name('aboutus_form');
            Route::match(['get', 'post'], '{type}-aboutus', 'save_aboutus')->name('save_aboutus');
            Route::match(['get', 'post'], 'about-us-detailview/{id}', 'about_us_details')->name('about_us_details');


            Route::match(['get', 'post'], 'certification', 'certificate_list')->name('certificate_list');
            Route::match(['get', 'post'], 'certification/{type}/{id}', 'certificate_form')->name('certificate_form');
            Route::match(['get', 'post'], '{type}-certification', 'save_certificate')->name('save_certificate');
            Route::match(['get', 'post'], 'certification-detailview/{id}', 'certificate_details')->name('certificate_details');

            // subscribe_emails 
            Route::match(['get', 'post'], 'subscribe_emails', 'subscribe_emails')->name('subscribe_emails');

            Route::match(['get', 'post'], 'category', 'category_list')->name('category_list');
            Route::match(['get', 'post'], 'category/{type}/{id}', 'category_form')->name('category_form');
            Route::match(['get', 'post'], '{type}-category', 'save_category')->name('save_category');


            Route::match(['get', 'post'], 'subcategory', 'subcategory_list')->name('subcategory_list');
            Route::match(['get', 'post'], 'subcategory/{type}/{id}', 'subcategory_form')->name('subcategory_form');
            Route::match(['get', 'post'], '{type}-subcategorys', 'save_subcategory')->name('save_subcategory');

            Route::match(['get', 'post'], 'infrastructure', 'infrastructure_list')->name('infrastructure_list');
            Route::match(['get', 'post'], 'infrastructure/{type}/{id}', 'infrastructure_form')->name('infrastructure_form');
            Route::match(['get', 'post'], '{type}-infrastructure', 'save_infrastructure')->name('save_infrastructure');

            Route::match(['get', 'post'], 'seo', 'seo_list')->name('seo_list');
            Route::match(['get', 'post'], 'seo/{type}/{id}', 'seo_form')->name('seo_form');
            Route::match(['get', 'post'], 'save-seo-data', 'save_seo')->name('save_seo');


            Route::match(['get', 'post'], 'help', 'help')->name('help');
            Route::match(['get', 'post'], 'enquiry-details', 'enquiry_list')->name('enquiry_list');
            Route::match(['get', 'post'], 'product_enquiry-details', 'product_enquiry_list')->name('product_enquiry_list');
            Route::match(['get', 'post'], 'dealer-details', 'dealer_list')->name('dealer_list');
            Route::match(['get', 'post'], 'profile', 'profile')->name('profile');


            Route::match(['get', 'post'], 'product', 'product_list')->name('product_list');
            Route::match(['get', 'post'], 'product/{type}/{id}', 'product_form')->name('product_form');
            Route::match(['get', 'post'], '{type}-products', 'save_product')->name('save_product');
            // // Delete Global Route
            Route::match(['get', 'post'], 'delete/{type}/{id}', 'delete_data')->name('delete_data');
        });
    });
});