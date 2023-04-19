<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CustomerRatesMovie;

class ApiController extends Controller{

  private $language_id = 1;

      public function getMovies() {
        $db_movie_info = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->get();

        return response()->json([
            "status"  => true,
            "data"    => $db_movie_info
        ], 201);
      }


      public function getMovie($show_id){
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

        return response()->json([
            "status"  => true,
            "data"    => $movie_data
        ], 201);
      }
  
      public function homemovies(){
        
        $this->language_id = config('app.language_id');

        $list_to_home = [];

        $db_list_shows = DB::table('system_list')
        ->join('system_list_description', 'system_list.system_list_id', '=', 'system_list_description.system_list_id')
        ->get();

        $db_list_shows = json_decode(json_encode($db_list_shows),true);

        foreach($db_list_shows as $db_list_show){
          
          $db_show_data = DB::table('movie')
          ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
          ->join('movie_to_system_list', 'movie.movie_id', '=', 'movie_to_system_list.movie_id')
          ->where('movie_to_system_list.system_list_id','=',$db_list_show['system_list_id'])
          ->get();

          $db_list_show['show_data'] = $db_show_data;

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
            $response['message'] = "Você marcou o filme como visto.";
          }
          else{
            $response['status'] = false;
            $response['message'] = "Erro ao marcar o filme como visto";
          }
        }
        else{
          $response['status'] = false;
          $response['message'] = "Você já marcou o filme como visto";
        }


        
        return response()->json([
          "status"  => true,
          "data"    => $response
      ], 201);
        
      }


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
            $response['status'] = true;
            $response['message'] = "Você avaliou o show.";
          }
          else{
            $response['status'] = false;
            $response['message'] = "O show não foi avaliado.";
          }

        }
        else{
          $response['status'] = false;
          $response['message'] = "Você ainda não marcou o filme como visto";
        }

        return response()->json([
          "status"  => true,
          "data"    => $response
      ], 201);

      }
}
