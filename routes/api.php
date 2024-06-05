<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
//use App\Http\Controllers\ApiGameController;
//use App\Http\Controllers\SseController;
use App\Http\Controllers\Auth\Api\RegisterController;

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

    //Account apis
    Route::post('/account',[ApiController::class,'getAccount']);
    Route::post('/account/sendImage',[ApiController::class,'sendImage']);
    Route::post('/account/changePassword',[ApiController::class,'changePassword']);
    Route::post('/account/changeData',[ApiController::class,'changeData']);
    Route::get('account/getMyStreamingList',[ApiController::class,'getMyStreamingList']);
    Route::post('/account/setMyStreaming',[ApiController::class,'setMyStreaming']);

    //Settings apis
    Route::get('setting/getCustomerSetting',[ApiController::class,'getCustomerSetting']);
    Route::post('/setting/updateSetting',[ApiController::class,'updateSetting']);
    

    //Home apis
    Route::get('homeBanners',[ApiController::class, 'getHomeBanners']);
    Route::get('homemovies',[ApiController::class, 'homemovies']);

    //App apis
    //Streaming apis
    Route::get('streaming_list',[ApiController::class, 'getStreamingList']); 
    Route::get('movies',[ApiController::class, 'getMovies']);
    Route::get('movie/{show_id}/{customer_id}',[ApiController::class, 'getMovie']);
   // Route::get('movie/{show_id}',[ApiController::class, 'getMovie']);
    Route::post('/movie/markThisShowAsSaw',[ApiController::class, 'markThisShowAsSaw']);
    Route::post('/movie/rateShow',[ApiController::class, 'rateMovie']);
    //List apis
    Route::get('mylists',[ApiController::class,'getMyLists']);
    Route::get('getMyListsWithShows/{customer_id}',[ApiController::class,'getMyListsWithShows']);
    Route::post('/myList/addShow',[ApiController::class, 'setShowToMyList']);
    Route::post('/myList/saveNewList',[ApiController::class, 'saveNewList']);
    Route::get('completeCustomerList',[ApiController::class, 'completeCustomerList']);
    
   
});


/**
 * Auth Routes, don´t need to be authenticated to access
 */
//Route::group(['middleware' => 'cors'], function () {
    Route::group(['prefix' => 'auth', 'middleware' => ['cors']], function(){
    Route::post('/login',[\App\Http\Controllers\Auth\Api\LoginController::class,'login']);

    Route::post('/logout',[\App\Http\Controllers\Auth\Api\LoginController::class,'logout']);

    Route::post('/newcustomer',[RegisterController::class,'register']);
    Route::post('/checkIfUserIdExists',[ApiController::class,'checkIfUserIdExists']);
    
    

    //tmp user Login
    //tmp_user_token
    //Route::post('tmpLogin',);


    //Rotas para teste
    Route::get('test',[ApiController::class,'test']);
    Route::post('test2',[ApiController::class,'teste2']);
    Route::post('/movie/rateShow2',[ApiController::class, 'rateMovie']);
    Route::get('movieaa/{show_id}/{customer_id}',[ApiController::class, 'getMovie']);

  //  Route::get('sse/showParty/{party_token}',[SseController::class,'showParty']);
   // Route::get('game/getParty/{party_token}',[ApiGameController::class,'getParty']);
 //   Route::post('game/createsParty',[ApiGameController::class,'createsParty']);
  //  Route::post('game/joinParty/{party_token}',[ApiGameController::class,'joinParty']);
});




