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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('friends', 'FriendshipController@index');
Route::get('people', 'FriendshipController@people');
Route::get('friends/del/{id}', 'FriendshipController@destroy');
Route::get('friends/add/{id}', 'FriendshipController@add');

Route::get('user/settings', 'UserController@settings');
Route::post('user/update', ['as' => 'user.settings', 'uses' => 'UserController@update']);
Route::post('user/post', ['as' => 'user.post', 'uses' => 'UserController@post']);
Route::post('user/addPicture', ['as' => 'user.addPicture', 'uses' => 'UserController@addpic']);
Route::get('user/{id}', 'UserController@show');
Route::get('del/post/{id}', 'UserController@delPost');
Route::get('del/photo/{id}', 'UserController@delPhoto');
Route::post('qr', 'UserController@qrauth');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::group(['prefix' => 'messages'], function () {
	Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
	Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
	Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
	Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
	Route::get('del/{id}', ['as' => 'messages.del', 'uses' => 'MessagesController@delMessage']);
	Route::get('ajax/{id}', ['as' => 'messages.show_ajax', 'uses' => 'MessagesController@show_ajax']);
	Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
	Route::post('addpic/{id}', ['as' => 'messages.addPicture', 'uses' => 'MessagesController@addPicture']);
	Route::post('addaudio/{id}', ['as' => 'messages.addaudio', 'uses' => 'MessagesController@addAudio']);
});
Route::get('dialog/del/{id}', 'MessagesController@delThread');