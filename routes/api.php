<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/users', 'App\Http\Controllers\GetRoutesController@getUsers');
    Route::get('/books', 'App\Http\Controllers\GetRoutesController@getBooks');
    Route::get('/rentals', 'App\Http\Controllers\GetRoutesController@getRentals');
    Route::get('/movies', 'App\Http\Controllers\GetRoutesController@getMovies');
    Route::get('/availableMovies', 'App\Http\Controllers\GetRoutesController@getAvailableMovies');
    Route::get('/availableBooks', 'App\Http\Controllers\GetRoutesController@getAvailableBooks');
    Route::get('/dueRentals', 'App\Http\Controllers\GetRoutesController@getDueRentals');
    Route::post('/rentItem', 'App\Http\Controllers\ItemController@rentItem');
    Route::post('/returnItem', 'App\Http\Controllers\ItemController@returnItem');
});
