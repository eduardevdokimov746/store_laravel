<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController')->name('index');

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::match(['get', 'head'], 'login', 'LoginController@showLoginForm')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::match(['get', 'head'], 'password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::match(['get', 'head'], 'password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');

    Route::post('password/checkcode', 'ForgotPasswordController@checkCode');

    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::match(['get', 'head'], 'password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset')->middleware('check.code.password.restore');
    Route::post('register', 'RegisterController@register');
    Route::match(['get', 'head'], 'register', 'RegisterController@showRegistrationForm')->name('register');

    Route::get('login/{provider}', 'SocialController@redirect')->middleware('guest');
    Route::get('login/{provider}/callback', 'SocialController@callback')->middleware('guest');

    Route::get('confirm/mail/{code}', 'ConfirmEmailController@handler')->name('confirm.mail');
    Route::post('confirm/mail/send', 'ConfirmEmailController@sendDublicateMail');

});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/changecurrency', 'CurrencyController@change')->name('changeCurrency');

Route::resource('cart', 'CartController')->names('cart')->except(['show', 'create', 'edit']);

Route::resource('products', 'ProductController')->names('products');

Route::post('cart/increment', 'CartController@increment')->name('cart.increment');
Route::post('cart/decrement', 'CartController@decrement')->name('cart.decrement');
Route::get('cart/flush', 'CartController@flush')->name('cart.flush');

Route::resource('products.comments', 'ProductCommentsController');

Route::resource('categories', 'CategoryController');
Route::get('categories/{slug}/products', 'CategoryController@products')->name('categories.products');

Route::middleware('auth')->group(function () {
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::post('profile/name-change', 'ProfileController@changeName');
    Route::get('profile/password-change', 'ProfileController@showFormChangePass')->name('change-password');
    Route::post('profile/password-change', 'ProfileController@changePassword');
});

Route::get('search/handle', 'SearchController@handle');
Route::get('search/{searchText}', 'SearchController@index');

Route::get('mail', function () {
   return new \App\Mail\ConfirmMail;
});
