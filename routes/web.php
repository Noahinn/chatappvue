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
Auth::routes();

Route::get('/', 'HomeController@index');

Route::post('room', 'ChatsController@room');

Route::post('loadmessage', 'ChatsController@loadMessages');

Route::post('messages', 'ChatsController@fetchMessages');

Route::post('sendmessage', 'ChatsController@sendMessage');

Route::post('add', 'UserController@add');

Route::post('delete', 'UserController@delete');

Route::post('accept', 'UserController@accept');

Route::get('/search/{name}', 'HomeController@search');

Route::get('/user/{oi}', 'UserController@profile');

Route::post('creategroup', 'ChatsController@createGroup');

Route::post('addmem', 'ChatsController@addMemGroup');

Route::post('sendmessagegroup', 'ChatsController@sendMessageGroup');

Route::post('loadmessagegroup', 'ChatsController@loadMessagesGroup');