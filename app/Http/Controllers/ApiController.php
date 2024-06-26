<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\JoinClause;


use App\Models\CustomerRatesMovie;
use App\Models\Movie;
use App\Models\MovieSeason;
use App\Models\MovieToCustomerList;
use App\Models\CustomerList;
use App\Models\CustomerStreaming;
use App\Models\CustomerSetting;

//https://mui.com/material-ui/getting-started/installation/

class ApiController extends Controller{

  private $language_id = 1;

      public function getAccount(Request $request){

        $token = $request->bearerToken();

        [$id, $token] = explode('|', $token, 2);

        $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $token))->first();
        if($token_data){
            $customer_data = DB::table('customer')->where('customer_id', $token_data->tokenable_id)->first();
            if($customer_data){
              $customer_user_id = is_null($customer_data->customer_user_id) ? "" : "@".$customer_data->customer_user_id;
              $response = array(
                "customer_user_id" => $customer_user_id,
                "customer_firstname" => $customer_data->customer_firstname,
                "customer_lastname" => $customer_data->customer_lastname,
                "customer_date_birth" => $customer_data->customer_date_birth,
                "customer_bio"        => $customer_data->customer_bio,
                "email" => $customer_data->email
              );
            }
            else $response = [];
        }
        else $response = [];

        

        return response()->json([
          "status"  => true,
          "data"    => $response
      ], 201);
      }

      public function sendImage(Request $request){
        //https://laracasts.com/discuss/channels/laravel/how-to-save-image-as-blob
        $token = $request->bearerToken();
        $customer_data = $this->getCustomerData($token);
        $image_url = "";
        if($customer_data){
          //php artisan storage:link
          $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
          ]);

          $image_url = url(Storage::url($request->file('image')->store('image', 'public')));

          DB::table('customer')->where('customer_id', $customer_data->customer_id)->update(['customer_image_url'=>$image_url]);
        }

        //customer_image_url //atualizar imagem na tabela do cliente
        return response()->json([
          "status"  => true,
          "data"    => $image_url
        ], 201);
    }


    public function changePassword(Request $request){
        $token = $request->bearerToken();
        $password = $request->pwd;

        [$id, $token] = explode('|', $token, 2);

        $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $token))->first();
        if($token_data){
            $customer_data = DB::table('customer')->where('customer_id', $token_data->tokenable_id)->first();
            if($customer_data){
              DB::table('customer')->where('customer_id', $token_data->tokenable_id)->update(['password'=>bcrypt($password)]);
              $response = true;
            }
            else $response = false;
        }
        else $response = false;

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);
    }


    public function changeData(Request $request){
      $token = $request->bearerToken();
      $data = $request->all();
      $customer_data = $this->getCustomerData($token);
      
      $customer_firstname = isset($data['firstname']) ? $data['firstname']:'';
      $customer_lastname  = isset($data['lastname']) ? $data['lastname']:'';
      $customer_bio       = isset($data['bio']) ? $data['bio'] : '';
      $customer_mail      = isset($data['email']) ? $data['email'] : '';

      if($customer_data!==false){
        DB::table('customer')->where('customer_id', $customer_data->customer_id)->update(
          ['customer_firstname'=>$customer_firstname,
          'customer_lastname'=>$customer_lastname,
          'email' => $customer_mail,
          'customer_bio'=>$customer_bio]);
      }
      $customer_data = $this->getCustomerData($token);
      $response_data = array(
        "customer_firstname" => $customer_data->customer_firstname,
        "customer_lastname" => $customer_data->customer_lastname,
        "customer_date_birth" => $customer_data->customer_date_birth,
        "customer_image_url" => $customer_data->customer_image_url,
        "customer_user_id"  => $customer_data->customer_user_id,
        "email" => $customer_data->email,
        "customer_bio" => $customer_data->customer_bio,
      );
      return response()->json([
        "status"  => true,
        "data"    => $response_data
      ], 201);
    }


    private function getCustomerData($token){
      [$id, $token] = explode('|', $token, 2);

      $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $token))->first();
      if($token_data){
          $customer_data = DB::table('customer')->where('customer_id', $token_data->tokenable_id)->first();
          return $customer_data;
      }
      else $response = false;
    }


    public function checkIfUserIdExists(Request $request){
      $data = $request->all();
      $customer = DB::table('customer')->where('customer_user_id', $data['userId'])->first();
      $response = [];
      $response['status'] = $customer ? false : true;
        return response()->json([
          "status"  => true,
          "data"    => $response
      ], 201);
    }


    public function setMyStreaming(Request $request){

      $token = $request->bearerToken();

      $data = $request->all();

      $streamings = $data['streamings'];

      $customer_data = $this->getCustomerData($token);

      if($customer_data!==false){

        CustomerStreaming::where('customer_id',$customer_data->customer_id)->delete();

        foreach($streamings as $streaming_id){
          $customer_streaming = new CustomerStreaming();
          $customer_streaming->customer_id =  $customer_data->customer_id;
          $customer_streaming->watch_provider_id = $streaming_id;
      
          $customer_streaming->save($data);
        }

      }

      $streamingsAnswer = $this->getStreamingResponse($customer_data);

      return response()->json([
        "status"  => true,
        "data"    => $streamingsAnswer
    ], 201);
    }
      /*
        =============================================================
        =============================================================
        =============================================================
        =============================================================
        =============================================================
      */
      public function getMovies() {
        $db_movie_info = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->get();

        return response()->json([
            "status"  => true,
            "data"    => $db_movie_info
        ], 201);
      }


      public function getMovie($show_id,Request $request){

      
        $movie_data = [];

        $token = $request->bearerToken();

        $inputs = $request->all();
    
        $customer_data = $this->getCustomerData($token);

       // $customer_data = false;

        if($customer_data){
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
          ->where('customer_rates_movie.customer_id','=',$customer_data->customer_id)
          ->get();
  
          $db_movie_watch_providers = DB::table('movie_to_watch_provider')
          ->join('watch_provider', 'movie_to_watch_provider.watch_provider_id', '=', 'watch_provider.watch_provider_id')
          ->where('movie_to_watch_provider.movie_id','=',$show_id)
          ->get();
  
          $db_my_list_info = DB::table('customer_list')
          ->select('customer_list.customer_list_id','customer_list.customer_list_name')
          ->join('movie_to_customer_list', 'customer_list.customer_list_id', '=', 'movie_to_customer_list.customer_list_id')
          ->where('customer_list.customer_id','=',$customer_data->customer_id)
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

        }


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

        $response = [];

        $inputs = $request->all();

        $token = $request->bearerToken();
    
        $customer_data = $this->getCustomerData($token);
  
        if($customer_data!==false){

          $show_id = $inputs['show_id'];
          $customer_id = $customer_data->customer_id;
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

        }


        
         return response()->json([
            "status"  => true,
            "data"    => $response
        ], 201);
        
      }



      public function completeCustomerList(Request $request){

        //here is a temp config to movie... let´s use the season 1 as the result of api only would be a movie, but when we became it to support a serie, it must to be addapted
        $season =1;

        $token = $request->bearerToken();

        $inputs = $request->all();
    
        $customer_data = $this->getCustomerData($token);
  
        if($customer_data!==false){
          $this->language_id = config('app.language_id');

          $list_to_customer = [];
  
          $db_list_shows = DB::table('customer_list')
          ->where('customer_id',$customer_data->customer_id)
          ->get();
  
          $db_list_shows = json_decode(json_encode($db_list_shows),true);
  
          foreach($db_list_shows as $db_list_show){
  
            $new_show_data = [];

            $searchString = isset($inputs['searchInputText']) && strlen($inputs['searchInputText']) > 0 ? $inputs['searchInputText'] : "";
            $genderFilterValues = isset($inputs['genderFilterValues']) && is_array($inputs['genderFilterValues']) && count($inputs['genderFilterValues']) > 0 ? $inputs['genderFilterValues'] : [];
             //filter
             
              $db_show_data = DB::table('movie')
              ->distinct()              
              ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
              ->join('movie_season', 'movie_season.movie_id', '=', 'movie.movie_id')
              ->join('movie_to_customer_list', 'movie.movie_id', '=', 'movie_to_customer_list.movie_id');
              
                  if(is_array($genderFilterValues) && count($genderFilterValues) > 0){
                    return $db_show_data->join('movie_to_movie_gender', 'movie.movie_id', '=', 'movie_to_movie_gender.movie_id');
                    //->on('movie.movie_id', '=', 'movie_to_movie_gender.movie_id');
                  }
               
              // ->join('movie_to_movie_gender',  function($query) use ($genderFilterValues){
              //   if(is_array($genderFilterValues) && count($genderFilterValues) > 0){
              //     $query->on('movie.movie_id', '=', 'movie_to_movie_gender.movie_id');
              //   }
              // })
              $db_show_data->where('movie_to_customer_list.customer_list_id','=',$db_list_show['customer_list_id'])
              ->when($searchString,function($query,$searchString){
                if(strlen($searchString) > 0){
                  return $query->where('movie_description.movie_description_name','LIKE',"%{$searchString}%");
                }
              })
              ->when($genderFilterValues,function($query,$genderFilterValues){
                if(is_array($genderFilterValues) && count($genderFilterValues) > 0){
                  return $query->whereIn('movie_to_movie_gender.movie_gender_id',$genderFilterValues);
                }
              })->get();
            
            // else{
            //   $db_show_data = DB::table('movie')
            //   ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
            //   ->join('movie_season', 'movie_season.movie_id', '=', 'movie.movie_id')
            //   ->join('movie_to_customer_list', 'movie.movie_id', '=', 'movie_to_customer_list.movie_id')
            //   ->where('movie_to_customer_list.customer_list_id','=',$db_list_show['customer_list_id'])
            //   ->get();
            // }
            
          

            if($db_show_data->count() > 0){
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
              $list_to_customer[] = $db_list_show;
            }
    
            
          }
        }
        
        

        return response()->json([
          "status"  => true,
          "data"    => $list_to_customer
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

          $token = $request->bearerToken();

          $response = [];
       
          $customer_data = $this->getCustomerData($token);
     
          if($customer_data!==false){
            $show_id         = $inputs['show_id'];
            $customer_id     = $customer_data->customer_id;
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

      public function getMyLists(Request $request,$returnResponse = false){

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        if($customer_data!==false){
          $myLists = DB::table('customer_list')
          ->where('customer_id', $customer_data->customer_id)
          ->get();
        }
        else $myLists = [];
   
        if(!$returnResponse){
            return response()->json([
              "status"  => true,
              "data"    => $myLists
          ], 201);
        }else{
          return $myLists;
        }
      }

      public function getMyListsReturn($customer_id){

        $myLists = DB::table('customer_list')
          ->where('customer_id', $customer_id)
          ->get();
        
        return $myLists;

      }

      public function getMyListsWithShows($customer_id,$returnResponse = false){

        $myLists = DB::table('customer_list')
        ->select('movie.movie_id','movie.movie_image_1','customer_rates_movie.customer_rates_movie_rate')
        ->join('movie_to_customer_list','customer_list.customer_list_id','=','movie_to_customer_list.customer_list_id')
        ->join('movie','movie_to_customer_list.movie_id','=','movie.movie_id')
        ->join('customer_rates_movie','movie.movie_id','=','customer_rates_movie.movie_id')
        ->where('customer_list.customer_id', $customer_id)
        ->where('customer_rates_movie.customer_id', $customer_id)
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

        $token = $request->bearerToken();

        $inputs = $request->all();

        $customer_data = $this->getCustomerData($token);

        $response = [];

        if($customer_data!==false){

          $show_id = $inputs['show_id'];
          $list_id = $inputs['list_id'];
          $customer_id = $customer_data->customer_id;

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

        }
        else{
          $response['status']     = false;
          $response['message']    = "Não encontramos suas informações.";
        }

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);
    

        

        
        
      }


      public function getStreamingList(Request $request){

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        $response = [];

        $streaming_list = [];

        
        $streaming_list = $this->getStreamingResponse($customer_data);

        if($streaming_list !== false){


          $response['status'] = true;

          $response['data']   = $streaming_list;
        }
        else {

          $response['status'] = false;

        }
  
        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);

      }



      public function getStreamingResponse($customer_data){

        $streaming_list = [];

        if($customer_data!==false){

          $streamings = DB::table('watch_provider')
          ->where('watch_provider.watch_provider_status', 1)
          ->get();

          foreach($streamings as $streaming){

            $countMyStreaming = DB::table('watch_provider_to_customer')
            ->where('watch_provider_to_customer.watch_provider_id',$streaming->watch_provider_id)
            ->where('watch_provider_to_customer.customer_id',$customer_data->customer_id)
            ->count();

            $streaming_list[] = array(
              'id'=>$streaming->watch_provider_id,
              'name'=>$streaming->watch_provider_name,
              'streaming_image_url'=> config('app.guzzle_tmd_image_url').'/'.$streaming->watch_provider_image_link,
              'myStreaming'=>$countMyStreaming>0 ? true : false
            );

          }

          return $streaming_list;
        }
        else return false;

        
      }


      public function getFilters(Request $request){

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        $response = [];

        if($customer_data){
          //Get show Search
          $response[] = array(
            'header' => 'Pesquisar',
            'type'   => 'search',
            'data'   => []
          );

          //Get Show Genders
          $genders = DB::table('movie_gender')
          ->select('movie_gender_id','movie_gender_name')
          ->where('movie_gender.language_id', $this->language_id)
          ->get();
          if($genders){
            $response[] = array(
              'header' => 'Generos',
              'type'   => 'gender',
              'data'   => $genders
            );
          }


          
        }

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);

      }


      public function getMyStreamingList(Request $request){

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        $response = [];

        if($customer_data!==false){

          $data = DB::table('watch_provider')
          ->join('watch_provider_to_customer','watch_provider.watch_provider_id','=','watch_provider_to_customer.watch_provider_id')
          ->where('watch_provider.watch_provider_status', 1)
          ->where('watch_provider_to_customer.customer_id', $customer_data->customer_id)
          ->get();

          $response['status'] = true;

          $response['data']   = $data;

        }

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);
       
      }

      public function saveNewList(Request $request){
        $inputs = $request->all();

        $response = [];

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        if($customer_data!==false){
          $customer_id   = $customer_data->customer_id;
        }
        else $customer_id = 0;


        
        $new_list_name = $inputs['new_list_name'];

        $dbCustomerList = new CustomerList();
        $dbCustomerList->customer_list_name = $new_list_name;
        $dbCustomerList->customer_id = $customer_id;
        $dbCustomerList->customer_list_date_added = date("Y-m-d");

        if($dbCustomerList->save()){
          $response['status']     = true;
          $response['message']    = "Você adicionou a Lista %list%.";
          $response['myLists']    = $this->getMyListsReturn($customer_id);
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

      public function updateSetting(Request $request){

        $inputs = $request->all();

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        $customer_settings = [];

        $settings = [];

        $response = [];

        $setting_keys = [];

        if($customer_data!==false){
          //1 - Checks if customer already has a setting saved, if it doesn´t, a new one will be created
          $customer_settings = DB::table("customer_setting")->where('customer_setting.customer_id','=',$customer_data->customer_id)->first();
          if(is_null($customer_settings)){
            
            foreach($inputs as $input){
              $settings[$input['key']] = $input['value'];
            }
            //1.1 - A new object´s setting will be created and saved
            $dbCustomerSetting = new CustomerSetting();
            $dbCustomerSetting->customer_id = $customer_data->customer_id;
            $dbCustomerSetting->customer_setting_setting = json_encode($settings);
            $dbCustomerSetting->save();
            $response = array("status"=>true,"message"=>"Configurações Atualizadas com Sucesso");
          }
          else{
          //2 - In case to exists some setting to customer, the settings will be updated
          //2.1 - In case to exists a key to customer´s settings the key´s value will be updated

            $settings = json_decode($customer_settings->customer_setting_setting,true);
            
            foreach($settings as $key => $value){
              $setting_keys[] = $key;
              foreach($inputs as $input){
                if($key == $input['key']){
                  $settings[$key] = $input['value'];
                }
              }
            }

            //2.2 - In case to not exists any key setting to customer, a new one is created
            foreach($inputs as $input){
              if(!in_array($input['key'],$setting_keys)){
                $settings[$input['key']] = $input['value'];
              }
            }

            //3 - Finally the settings json string is updated
            $settings = json_encode($settings);
            CustomerSetting::where('customer_id', $customer_data->customer_id)
            ->update([
              'customer_setting_setting' => $settings
            ]);
            
            $response = array("status"=>true,"message"=>"Configurações Atualizadas com Sucesso");
          }
        }

        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);
      }

      public function getCustomerSetting(Request $request){

        $inputs = $request->all();

        $token = $request->bearerToken();

        $customer_data = $this->getCustomerData($token);

        $response = [];
       
        if($customer_data!==false){
          
          //1 - Checks if customer already has a setting saved, if it doesn´t, a new one will be created
          $customer_settings = DB::table("customer_setting")->where('customer_setting.customer_id','=',$customer_data->customer_id)->first();
 
          if(!is_null($customer_settings)){
            $response = array(
              'data' => $customer_settings->customer_setting_setting,
              'status' => true
            );
          }
          else {
            $response = array(
              'status' => false
            );
          }
        }
        else {
          $response = array(
            'status' => false
          );
        }

        return response()->json($response, 201);

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
