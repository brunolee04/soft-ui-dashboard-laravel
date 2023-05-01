<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('homemovies',[ApiController::class, 'homemovies']);
})

Route::get('movies',[ApiController::class, 'getMovies']);
Route::get('movie/{show_id}',[ApiController::class, 'getMovie']);
Route::get('movie/{show_id}',[ApiController::class, 'getMovie']);
Route::post('/movie/markThisShowAsSaw',[ApiController::class, 'markThisShowAsSaw']);
Route::post('/movie/rateShow',[ApiController::class, 'rateMovie']);






Route::get('homeBanners',[ApiController::class, 'getHomeBanners']);



Route::prefix('auth')->group(function(){
    Route::post('login',[\App\Http\Controllers\Auth\Api\LoginController::class,'login']);

    Route::post('logout',[\App\Http\Controllers\Auth\Api\LoginController::class,'logout']);

    Route::post('register',[\App\Http\Controllers\Auth\Api\RegisterController::class,'register']);
});




