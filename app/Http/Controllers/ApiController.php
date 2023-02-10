<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller{

  private $language_id = 0;

    public function getMovies() {
        $db_movie_info = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->get();

        return response()->json([
            "status"  => true,
            "data"    => $db_movie_info
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
}
