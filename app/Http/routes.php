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

Route::get('/info', function() {
	return phpinfo();
});

// Authentication routes
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@authenticate');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@PostEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@PostReset');

// member area
Route::get('member/profile', 'MemberController@getProfile');
Route::post('member/profile', 'MemberController@postProfile');
Route::post('member/profile/{id}', 'MemberController@updateProfile');
Route::get('member/transaction', 'MemberController@getTransactionList');
Route::get('member/transaction/{id}', 'MemberController@getTransactionDetail');

Route::get('cart', 'CartController@index');
Route::get('cart/addItem/{productId}', 'CartController@addItem');
Route::post('cart/updateItem/{id}', 'CartController@updateItem');
Route::get('cart/removeItem/{id}', 'CartController@removeItem');
Route::get('cart/checkout', 'CartController@getCheckout');

Route::post('cart/payment/bank-transfer', 'CartController@paymentBank');
Route::post('cart/payment/creditcard', 'CartController@paymentCreditCard');

Route::resource('order', 'OrderController');

// Registration routes
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Admin routes
Route::group(['prefix' => 'admin'], function() {
	
	Route::get('/', 'AdminController@index');

	Route::get('login', 'AdminController@getLogin');
	Route::post('login', 'AdminController@postLogin');
	Route::get('logout', 'AdminController@getLogout');

	Route::get('order', 'OrderController@getOrderList');
	Route::get('invoice', 'AdminController@getInvoice');
	Route::get('manage', 'AdminController@getAdminList');
	Route::get('messages', 'AdminController@getMessageList');
	Route::get('add', 'AdminController@create');
	Route::post('/', 'AdminController@store');
	Route::get('{id}/edit', 'AdminController@edit');
	Route::patch('{id}', 'AdminController@update');
	Route::delete('{id}', 'AdminController@destroy');

	Route::resource('product', 'ProductController');
	Route::resource('category', 'CategoryController');

});