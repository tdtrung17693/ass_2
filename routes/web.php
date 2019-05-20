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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// BOOK
Route::get('/', 'BookController@index');
Route::get('/books/new', 'BookController@create');
Route::post('/books/new', 'BookController@store');
Route::get('/books/edit/{id}', 'BookController@edit');
Route::get('/books/delete/{id}', 'BookController@destroy');
Route::put('/books/{id}', 'BookController@update');
Route::get('/books/{id}', 'BookController@view');

// AUTHOR
Route::get('/authors/{id}', 'AuthorController@view');
Route::post('/authors/new_from_book', 'AuthorController@insert_from_book');

// COMMUNITY
Route::get('/communities/', 'CommunityController@index');
Route::get('/communities/new', 'CommunityController@create');
Route::post('/communities/new', 'CommunityController@store');
Route::get('/communities/edit/{id}', 'CommunityController@edit');
Route::get('/communities/delete/{id}', 'CommunityController@destroy');
Route::put('/communities/{id}', 'CommunityController@update');

// USER
Route::post('/users/new', 'UserController@store');
Route::get('/users/new', 'UserController@create');
Route::get('/users/edit/{UserID}', 'UserController@edit');
Route::get('/users', 'UserController@index');
Route::get('/users/{UserID}', 'UserController@view');
Route::put('/users/{UserID}', 'UserController@update');
Route::get('/users/delete/{UserID}', 'UserController@destroy');

// MESSENGER
Route::get('/messenger', 'MessageController@index');
Route::get('/messenger/{BoxID}', 'MessageController@index');
Route::get('/messenger/{BoxID}/mb/{UserID}', 'MessageController@view_mb_msgs');
Route::get('/search', 'MiscController@search_endpoint');
Route::get('/search_msg_by_user', 'MiscController@search_msg');
Route::post('/search_msg_by_user', 'MiscController@search_msg_endpoint');

Route::get('/test', function () {
    phpinfo();
});