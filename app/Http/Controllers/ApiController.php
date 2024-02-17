<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\CustomerRatesMovie;
use App\Models\Movie;
use App\Models\MovieSeason;
use App\Models\MovieToCustomerList;
use App\Models\CustomerList;


class ApiController extends Controller{

  private $language_id = 1;

      public function getAccount(Request $request){
        //Get access token
        $access_token = $request->header('Authorization');

        // break up the string to get just the token
        $auth_header = explode(' ', $access_token);
        
        $token = $auth_header[1];
        
        // break up the token into its three parts
        $token_parts = explode('.', $token);
        
        $token_header = $token_parts[0];

        // base64 decode to get a json string
        $token_header_json = base64_decode($token_header);

        var_dump($token_header_json);
        
        // then convert the json to an array
        $token_header_array = json_decode($token_header_json, true);
        
       // $user_token = $token_header_array['jti'];
        
        // find the user ID from the oauth access token table
        // based on the token we just got
       // $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->first();

        

        // then retrieve the user from it's primary key
        // $user = User::find($user_id->id);

        // echo $user->id ?? '';
        // exit();


      }

      public function getMovies() {
        $db_movie_info = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->get();

        return response()->json([
            "status"  => true,
            "data"    => $db_movie_info
        ], 201);
      }


      public function getMovie($show_id,$customer_id){

      
        $movie_data = [];

        $db_movie_info = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->join('movie_season', 'movie.movie_id', '=', 'movie_season.movie_id')
        ->where('movie.movie_id','=',$show_id)
        ->get();

        $db_movie_gender_info = DB::table('movie_gender')
        ->select('movie_gender.movie_gender_id','movie_gender_name')
        ->join('movie_to_movie_gender', 'movie_gender.movie_gender_id', '=', 'movie_to_movie_gender.movie_gender_id')
        ->where('movie_to_movie_gender.movie_id','=',$show_id)
        ->where('movie_gender.language_id','=',$this->language_id)
        ->get();

        $db_movie_collection_info = DB::table('movie_collection')
        ->select('movie_collection.movie_collection_id','movie_collection_name','movie_collection_image_url')
        ->join('movie_to_movie_collection', 'movie_collection.movie_collection_id', '=', 'movie_to_movie_collection.movie_collection_id')
        ->where('movie_to_movie_collection.movie_id','=',$show_id)
        ->get();

        $db_movie_image_info = DB::table('movie_image')
        ->where('movie_id','=',$show_id)
        ->get();

        $db_movie_keyword_info = DB::table('movie_key_word')
        ->select('movie_key_word.movie_key_word_id','keyword')
        ->join('movie_key_word_to_movie', 'movie_key_word.movie_key_word_id', '=', 'movie_key_word_to_movie.movie_key_word_id')
        ->where('movie_key_word_to_movie.movie_id','=',$show_id)
        ->get();

        $db_movie_production_company_info = DB::table('production_company')
        ->select('production_company.production_company_id','production_company_name','production_companies_logo_url')
        ->join('movie_to_production_company', 'production_company.production_company_id', '=', 'movie_to_production_company.production_company_id')
        ->where('movie_to_production_company.movie_id','=',$show_id)
        ->get();

        $db_movie_video_info = DB::table('movie_video')
        ->join('movie_video_description', 'movie_video.movie_video_id', '=', 'movie_video_description.movie_video_id')
        ->where('movie_video_description.language_id','=',$this->language_id)
        ->where('movie_video.movie_id','=',$show_id)
        ->get();

        $db_movie_actor_info = DB::table('actor')
        ->select('actor.actor_id','actor_name','actor_image_url','actor_character')
        ->join('actor_to_movie', 'actor.actor_id', '=', 'actor_to_movie.actor_id')
        ->where('actor_to_movie.movie_id','=',$show_id)
        ->get();

        $db_movie_director_info = DB::table('director')
        ->select('director.director_id','director_name','director_image_url')
        ->join('director_to_movie', 'director.director_id', '=', 'director_to_movie.director_id')
        ->where('director_to_movie.movie_id','=',$show_id)
        ->get();

        $db_movie_writer_info = DB::table('writer')
        ->select('writer.writer_id','writer_name')
        ->join('writer_to_movie', 'writer.writer_id', '=', 'writer_to_movie.writer_id')
        ->where('writer_to_movie.movie_id','=',$show_id)
        ->get();


        $db_my_rate_movie_info = DB::table('customer_rates_movie')
        ->select('customer_rates_movie.customer_rates_movie_id','customer_rates_movie.customer_rates_movie_rate','customer_rates_movie.customer_rates_movie_date_added','customer_rates_movie.movie_season_id')
        ->where('customer_rates_movie.movie_id','=',$show_id)
        ->where('customer_rates_movie.customer_id','=',$customer_id)
        ->get();

        $db_movie_watch_providers = DB::table('movie_to_watch_provider')
        ->join('watch_provider', 'movie_to_watch_provider.watch_provider_id', '=', 'watch_provider.watch_provider_id')
        ->where('movie_to_watch_provider.movie_id','=',$show_id)
        ->get();

        $db_my_list_info = DB::table('customer_list')
        ->select('customer_list.customer_list_id','customer_list.customer_list_name')
        ->join('movie_to_customer_list', 'customer_list.customer_list_id', '=', 'movie_to_customer_list.customer_list_id')
        ->where('customer_list.customer_id','=',$customer_id)
        ->where('movie_to_customer_list.movie_id','=',$show_id)
        ->get();




        $movie_data['db_movie_info'] = $db_movie_info;
        $movie_data['db_movie_gender_info'] = $db_movie_gender_info;
        $movie_data['db_movie_image_info'] = $db_movie_image_info;
        $movie_data['db_movie_keyword_info'] = $db_movie_keyword_info;
        $movie_data['db_movie_production_company_info'] = $db_movie_production_company_info;
        $movie_data['db_movie_collection_info'] = $db_movie_collection_info;
        $movie_data['db_movie_video_info'] = $db_movie_video_info;
        $movie_data['db_movie_actor_info'] = $db_movie_actor_info;
        $movie_data['db_movie_director_info'] = $db_movie_director_info;
        $movie_data['db_movie_writer_info'] = $db_movie_writer_info;
        $movie_data['db_my_rate_movie_info'] = $db_my_rate_movie_info;
        $movie_data['db_movie_watch_providers'] = $db_movie_watch_providers;
        $movie_data['db_my_list_info'] = $db_my_list_info;
       

        return response()->json([
            "status"  => true,
            "data"    => $movie_data
        ], 201);
      }
  
      public function homemovies(){

        //here is a temp config to movie... let´s use the season 1 as the result of api only would be a movie, but when we became it to support a serie, it must to be addapted
        $season =1;
        
        $this->language_id = config('app.language_id');

        $list_to_home = [];

        $db_list_shows = DB::table('system_list')
        ->join('system_list_description', 'system_list.system_list_id', '=', 'system_list_description.system_list_id')
        ->get();

        $db_list_shows = json_decode(json_encode($db_list_shows),true);

        foreach($db_list_shows as $db_list_show){

          $new_show_data = [];
          
          $db_show_data = DB::table('movie')
          ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
          ->join('movie_season', 'movie_season.movie_id', '=', 'movie.movie_id')
          ->join('movie_to_system_list', 'movie.movie_id', '=', 'movie_to_system_list.movie_id')
          ->where('movie_to_system_list.system_list_id','=',$db_list_show['system_list_id'])
          ->get();

          //getting the movie genres
          foreach($db_show_data as $db_show_data_one){
            $db_show_data_one->genres = DB::table('movie_gender')
          ->select('movie_gender.movie_gender_id','movie_gender_name')
          ->join('movie_to_movie_gender', 'movie_gender.movie_gender_id', '=', 'movie_to_movie_gender.movie_gender_id')
          ->where('movie_to_movie_gender.movie_id','=',$db_show_data_one->movie_id)
          ->where('movie_gender.language_id','=',$this->language_id)
          ->get();
            $new_show_data[] = $db_show_data_one;
          }

          $db_list_show['show_data'] = $new_show_data;

          $list_to_home[] = $db_list_show;
        }

        return response()->json([
          "status"  => true,
          "data"    => $list_to_home
      ], 201);
      }

      public function getHomeBanners(){
        $banners = DB::table('banner')
        ->orderBy('banner.banner_id')
        ->get();

          return response()->json([
            "status"  => true,
            "data"    => $banners
        ], 201);

      }

      public function markThisShowAsSaw(Request $request){

        $inputs = $request->all();

        $response = [];

        $show_id = $inputs['show_id'];
        $customer_id = $inputs['customer_id'];
        $movie_season_id = $inputs['movie_season_id'];
       
        $customer_rates_movie_info = DB::table('customer_rates_movie')
                  ->where('customer_id',$customer_id)
                  ->where('movie_id',$show_id)
                  ->where('movie_season_id',$movie_season_id)
                  ->first();

        if(is_null($customer_rates_movie_info)){

          $dbCustomerRatesMovie = new CustomerRatesMovie();

          $dbCustomerRatesMovie->customer_rates_movie_rate = null;
          $dbCustomerRatesMovie->customer_rates_movie_date_added = date("Y-m-d H:i:s");
          $dbCustomerRatesMovie->movie_id = $show_id;
          $dbCustomerRatesMovie->customer_id = $customer_id;
          $dbCustomerRatesMovie->movie_season_id = $movie_season_id;

          if($dbCustomerRatesMovie->save()){
            $response['status'] = true;
            $response['message'] = "Você marcou %o% %show% como visto.";
          }
          else{
            $response['status'] = false;
            $response['message'] = "Erro ao marcar %o% %show% como visto";
          }
        }
        else{
          $response['status'] = false;
          $response['message'] = "Você já marcou %o% %show% como visto";
        }


        
        return response()->json([
          "status"  => true,
          "data"    => $response
      ], 201);
        
      }
   
      /**
       * Rate Movie
       *
       * @param Request $request
       * @return json data
       */
      public function rateMovie(Request $request){

          $inputs = $request->all();

          $response = [];

          $show_id         = $inputs['show_id'];
          $customer_id     = $inputs['customer_id'];
          $movie_season_id = $inputs['movie_season_id'];
          $rate            = $inputs['rate'];

          
          $customer_rates_movie_info = DB::table('customer_rates_movie')
          ->where('customer_id',$customer_id)
          ->where('movie_id',$show_id)
          ->where('movie_season_id',$movie_season_id)
          ->first();

          if(!is_null($customer_rates_movie_info)){
            $customer_rates_movie_id = $customer_rates_movie_info->customer_rates_movie_id;

            $customerRateInfo = CustomerRatesMovie::find($customer_rates_movie_id);
            
            $customerRateInfo->customer_rates_movie_rate = $rate;

            if($customerRateInfo->save()){

              //makes the general rate
              $mediumRate = $this->generalRateToMovie($show_id,$movie_season_id);

              $response['status']     = true;
              $response['mediumRate'] = $mediumRate;
              $response['myRate']     = $rate;
              $response['message']    = "Você avaliou %o% %show%.";
             
            }
            else{
              $response['status'] = false;
              $response['mediumRate'] = 0;
              $response['message'] = "%o% %show% não foi avaliado.";
            }

          }
          else{
            $response['status'] = false;
            $response['message'] = "Você ainda não marcou %o% %show% como visto.";
          }

          
          return response()->json([
            "status"  => true,
            "data"    => $response
        ], 201);

      }
      /**
       * Rate the movie with general rating
       *
       * @param [int] $movie_id
       * @param [int] $movie_season_id
       * @return void
       */
      private function generalRateToMovie($movie_id,$movie_season_id){

        $rateSum    = DB::table('customer_rates_movie')
                  ->select("customer_rates_movie_rate as totalRate")
                  ->where('movie_id', $movie_id)
                  ->where('movie_season_id', $movie_season_id)
                  ->sum('customer_rates_movie_rate');

        $rateQty  = DB::table('customer_rates_movie')
        ->where('movie_id', $movie_id)
        ->where('movie_season_id', $movie_season_id)
        ->count('customer_rates_movie_id');   
        
    
        $mediumRate = $rateSum > 0 && $rateQty > 0 ? $rateSum / $rateQty : 0;

        //echo "publico: ".$mediumRate;

        MovieSeason::where('movie_id', $movie_id)
        ->where('movie_season_id', $movie_season_id)
        ->update([
          'rating' => $mediumRate
        ]);
                  
        return $mediumRate;
      }


      public function getMyLists($customer_id,$returnResponse = false){

        $myLists = DB::table('customer_list')
        ->where('customer_id', $customer_id)
        ->get();
        
        if(!$returnResponse){
            return response()->json([
              "status"  => true,
              "data"    => $myLists
          ], 201);
        }else{
          return $myLists;
        }
          
      }

      public function setShowToMyList(Request $request){
        $inputs = $request->all();

        $response = [];

        $show_id = $inputs['show_id'];
        $list_id = $inputs['list_id'];
        $customer_id = $inputs['customer_id'];

        //1º - Checks if show is already in a List

        $db_my_list_info = DB::table('customer_list')
        ->select('movie_to_customer_list.movie_to_customer_list_id')
        ->join('movie_to_customer_list', 'customer_list.customer_list_id', '=', 'movie_to_customer_list.customer_list_id')
        ->where('customer_list.customer_id','=',$customer_id)
        ->where('movie_to_customer_list.movie_id','=',$show_id)
        ->first();

        if($db_my_list_info){
          MovieToCustomerList::where('movie_to_customer_list_id',$db_my_list_info->movie_to_customer_list_id )->delete();
        }

    

        $dbShowToCustomerList = new MovieToCustomerList();

        $dbShowToCustomerList->customer_list_id = $list_id;
        $dbShowToCustomerList->movie_id = $show_id;

        if($dbShowToCustomerList->save()){
          $response['status']     = true;
          $response['message']    = "Você adicionou %o% %show% na lista %list%.";
        }
        else{
          $response['status']     = false;
          $response['message']    = "Estamos com problemas em adcionar %o% %show% na lista %list%, tente novamente mais tarde.";
        }

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);
        
      }

      public function saveNewList(Request $request){
        $inputs = $request->all();

        $response = [];

        $customer_id   = $inputs['customer_id'];
        $new_list_name = $inputs['new_list_name'];

        $dbCustomerList = new CustomerList();
        $dbCustomerList->customer_list_name = $new_list_name;
        $dbCustomerList->customer_id = $customer_id;
        $dbCustomerList->customer_list_date_added = date("Y-m-d");

        if($dbCustomerList->save()){
          $response['status']     = true;
          $response['message']    = "Você adicionou a Lista %list%.";
          $response['myLists']    = $this->getMyLists($customer_id,true);
        }
        else{
          $response['status']     = false;
          $response['message']    = "Estamos com problemas em adcionar  a Lista %list%, tente novamente mais tarde.";
          $response['myLists']    =  null;
        }

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);
      }


      public function test(){
        $show=6;
        $season = 1;
        
        $this->generalRateToMovie($show,$season);
      }

      public function teste2(Request $request){
        echo "ok";
      }
      
      
}
