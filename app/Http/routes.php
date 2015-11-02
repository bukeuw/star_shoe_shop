<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Front page
Route::get('/', 'ProductController@showRecentProduct');
Route::get('product', 'ProductController@showProduct');
Route::get('about', 'MemberController@showAbout');
Route::get('contact', 'MemberController@getContact');
Route::post('contact', 'MemberController@postContact');

// Authentication routes
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// member area
Route::get('cart', 'CartController@index');
Route::get('cart/addItem/{productId}', 'CartController@addItem');
Route::post('cart/updateItem/{id}', 'CartController@updateItem');
Route::get('cart/removeItem/{id}', 'CartController@removeItem');
Route::resource('order', 'OrderController');

// Registration routes
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Admin routes
Route::group(['prefix' => 'admin'], function() {

	Route::get('login', 'AdminController@getLogin');
	Route::post('login', 'AdminController@postLogin');
	Route::get('logout', 'AdminController@getLogout');
	Route::get('/', 'AdminController@index');
	Route::resource('product', 'ProductController');
	Route::get('order', 'OrderController@getOrderList');
	Route::get('invoice', 'AdminController@getInvoice');
	Route::get('manage', 'AdminController@getAdminList');

});