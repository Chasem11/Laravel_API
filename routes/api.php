<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetRoutesController;
use App\Http\Controllers\ItemController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class,'login']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refresh', [AuthController::class,'refresh']);
    Route::post('/getSession', [AuthController::class,'getSession']);

});

Route::group([

    'middleware' => ['api', 'auth:api'],
    'prefix' => 'v1'

], function ($router) {
    Route::get('/users', [GetRoutesController::class,'getUsers']);
    Route::get('/books', [GetRoutesController::class,'getBooks']);
    Route::get('/rentals', [GetRoutesController::class,'getRentals']);
    Route::get('/movies', [GetRoutesController::class,'getMovies']);
    Route::get('/availableMovies', [GetRoutesController::class,'availableMovies']);
    Route::get('/availableBooks', [GetRoutesController::class,'availbleBooks']);
    Route::get('/dueRentals', [GetRoutesController::class,'getDueRentals']);
    Route::post('/rentItem', [ItemController::class,'rentItem']);
    Route::post('/returnItem', [ItemController::class,'returnItem']);
});
