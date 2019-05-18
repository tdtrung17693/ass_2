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

Route::get('/', 'BookController@index');
Route::get('/books/new', 'BookController@create');
Route::post('/books/new', 'BookController@store');

Route::post('/users/new', 'UserController@store');
Route::get('/users/new', 'UserController@create');

Route::get('/search', 'MiscController@search_endpoint');

Route::get('/test', function () {
    phpinfo();
});