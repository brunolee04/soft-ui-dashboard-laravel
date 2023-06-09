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


/**
 * App Routes, needed to be authenticated to access
 */
Route::middleware(['auth:sanctum'])->group(function () {
    //Home apis
    Route::get('homeBanners',[ApiController::class, 'getHomeBanners']);
    Route::get('homemovies',[ApiController::class, 'homemovies']);

    //App apis
    Route::get('movies',[ApiController::class, 'getMovies']);
    Route::get('movie/{show_id}',[ApiController::class, 'getMovie']);
    Route::get('movie/{show_id}',[ApiController::class, 'getMovie']);
    Route::post('/movie/markThisShowAsSaw',[ApiController::class, 'markThisShowAsSaw']);
    Route::post('/movie/rateShow',[ApiController::class, 'rateMovie']);
});


/**
 * Auth Routes, don´t need to be authenticated to access
 */
Route::prefix('auth')->group(function(){
    Route::post('login',[\App\Http\Controllers\Auth\Api\LoginController::class,'login']);

    Route::post('logout',[\App\Http\Controllers\Auth\Api\LoginController::class,'logout']);

    Route::post('register',[\App\Http\Controllers\Auth\Api\RegisterController::class,'register']);

    Route::get('test',[ApiController::class,'test']);

});




