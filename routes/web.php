<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', 'App\Http\Controllers\GetRoutesController@getUsers');
Route::get('/books', 'App\Http\Controllers\GetRoutesController@getBooks');
Route::get('/rentals', 'App\Http\Controllers\GetRoutesController@getRentals');
Route::get('/movies', 'App\Http\Controllers\GetRoutesController@getMovies');
Route::get('/availableMovies', 'App\Http\Controllers\GetRoutesController@getAvailableMovies');
Route::get('/availableBooks', 'App\Http\Controllers\GetRoutesController@getAvailableBooks');
Route::get('/dueRentals', 'App\Http\Controllers\GetRoutesController@getDueRentals');

Route::get('/displayUserView', 'App\Http\Controllers\ViewController@displayUserView');
Route::get('/displayHomeView', 'App\Http\Controllers\ViewController@displayHomeView');
Route::get('/displayBooksView', 'App\Http\Controllers\ViewController@displayBookView');
Route::get('/displayMoviesView', 'App\Http\Controllers\ViewController@displayMovieView');
Route::get('/displayRentView', 'App\Http\Controllers\ViewController@displayRentView');
Route::get('/displayReturnView', 'App\Http\Controllers\ViewController@displayReturnView');

Route::post('/createUser', 'App\Http\Controllers\GetRoutesController@createUser');
Route::post('/rentItem', 'App\Http\Controllers\ItemController@rentItem');
Route::post('/returnItem', 'App\Http\Controllers\ItemController@returnItem');