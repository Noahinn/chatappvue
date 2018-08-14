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

Route::get('/chat/{room}', 'ChatsController@room');

Route::get('/chat', 'ChatsController@index');

Route::get('messages', 'ChatsController@fetchMessages');

Route::post('messages', 'ChatsController@sendMessage');

Route::post('add', 'UserController@add');

Route::post('delete', 'UserController@delete');

Route::post('accept', 'UserController@accept');

Route::post('/search', 'HomeController@search');

Route::get('/user/{oi}', 'UserController@profile');