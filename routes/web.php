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

Route::get('/users', 'App\Http\Controllers\Controller@getUsers');
Route::get('/books', 'App\Http\Controllers\Controller@getBooks');
Route::get('/rentals', 'App\Http\Controllers\Controller@getRentals');
Route::get('/movies', 'App\Http\Controllers\Controller@getMovies');

Route::get('/dueRentals', 'App\Http\Controllers\Controller@getDueRentals');