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

//Route::get('/chat', 'ChatsController@index');

Route::post('messages', 'ChatsController@fetchMessages');

Route::post('sendmessage', 'ChatsController@sendMessage');

Route::post('add', 'UserController@add');

Route::post('delete', 'UserController@delete');

Route::post('accept', 'UserController@accept');

Route::get('/search/{name}', 'HomeController@search');

Route::get('/user/{oi}', 'UserController@profile');