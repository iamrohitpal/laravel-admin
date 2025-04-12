<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::controller(WebController::class)->group(function () {
    Route::get('/', 'index')->name('index');

    // about
    Route::get('about', 'about')->name('about');
    Route::get('mission-vision', 'mission_vision')->name('mission_vision');
    Route::get('our-strength', 'our_strength')->name('our_strength');
    Route::get('promoters', 'promoters')->name('promoters');

    // our product
    Route::get('all-categories', 'all_categories')->name('all_categories');
    Route::get('{slug}.html', 'master_function')->name('products');

    // blog
    Route::get('blog/{slug}', 'blog_details')->name('web_blog_details');
    Route::get('blogs', 'blogs')->name('blogs');

    // other
    Route::get('quality', 'quality')->name('quality');
    Route::get('certificate', 'certificate')->name('certificate');
    Route::get('contact', 'contact')->name('contact');
    Route::post('save-enquiry', 'save_enquiry')->name('save_enquiry');
});
