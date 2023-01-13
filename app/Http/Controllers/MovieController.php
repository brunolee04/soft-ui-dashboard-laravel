<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller{
    //

    public function list(){
        return view('movie/list');
    }

    public function register(){
        return view('movie/register');
    }

    public function edit(){
        return view('movie/editer');
    }


    private function getYearLaunch($dateString){
        
        return date('Y', strtotime($dateString));
    }

    public function save(Request $request){
        $movie_id = $request->input('movie_id');
        
        if($this->formValidation(array('movie_id'=>1))){

            $theUrl     = config('app.guzzle_tmd_api_url').'/movie/'.$movie_id.'?api_key='.config('app.guzzle_tmd_api_key').'&language=pt-BR';

            $response   = Http ::get($theUrl);
            
            //
            if($response->getStatusCode()==200){
               $movie_info =  $response->json();
               $dbMovie = new Movie();

               var_dump($movie_info);

               $dbMovie->movie_duration = $movie_info['runtime'];
               
               $dbMovie->movie_date_launch = $movie_info['release_date'];

               $dbMovie->movie_year_launch = $this->getYearLaunch($movie_info['release_date']);

               $dbMovie->movie_parental_rating = "L" ;//procurar da api

               $dbMovie->movie_date_added = date("Y-m-d");

               $dbMovie->movie_imdb_id = $movie_info['imdb_id'];

               $dbMovie->movie_feed_url = $theUrl;

               echo $theUrl;

             // var_dump($movie_info['runtime']);
            }
            
            //return $users;
        }

        
    }

    private function formValidation($rules){
        $countErrors = 0 ;

        foreach($rules as $field_name => $value){

            if(strlen($field_name)<$value)$countErrors++;
        }

        return $countErrors > 0 ? false : true;
    }
}
