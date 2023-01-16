<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\MovieGenderController;

use App\Models\Movie;
use App\Models\MovieDescription;
use App\Models\MovieGender;


class MovieController extends Controller{
    //

    private $language_id = 0;

    private $show_type = array(
                                'movie' => 0,
                                'serie' => 1
                            );
                            

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
        $this->language_id = config('app.language_id');

        $movie_id = $request->input('movie_id');
        
        if($this->formValidation(array('movie_id'=>1))){

            $theUrl     = config('app.guzzle_tmd_api_url').'/movie/'.$movie_id.'?api_key='.config('app.guzzle_tmd_api_key').'&language=pt-BR';

            $response   = Http ::get($theUrl);
           
            //
            if($response->getStatusCode()==200){
               $movie_info =  $response->json();
               $dbMovie = new Movie();

               var_dump($movie_info);

               $movie_image_1 = config('app.guzzle_tmd_image_url').$movie_info['poster_path'];

               $movie_image_1_parts = explode('/', $movie_image_1);

               $local_image_url1 = config('app.local_image_url').'/movie/'.end($movie_image_1_parts); 

               Storage::disk('local')->put(config('app.local_movie_image_url').end($movie_image_1_parts), file_get_contents($movie_image_1));


               $movie_image_2 = config('app.guzzle_tmd_image_url').$movie_info['backdrop_path'];
               
               $movie_image_2_parts = explode('/', $movie_image_2);

               $local_image_url2 = config('app.local_image_url').'/movie/'.end($movie_image_2_parts); 

               Storage::disk('local')->put(config('app.local_movie_image_url').end($movie_image_2_parts), file_get_contents($movie_image_2));



               $dbMovie->movie_duration = $movie_info['runtime'];
               
               $dbMovie->movie_date_launch = $movie_info['release_date'];

               $dbMovie->movie_year_launch = $this->getYearLaunch($movie_info['release_date']);

               $dbMovie->movie_parental_rating = "L" ;//procurar da api

               $dbMovie->movie_date_added = date("Y-m-d");

               $dbMovie->movie_imdb_id = $movie_info['imdb_id'];

               $dbMovie->movie_feed_url = $theUrl;

               $dbMovie->movie_image_1 = config('app.guzzle_tmd_image_url').$movie_info['poster_path'];

               $dbMovie->movie_image_2 = config('app.guzzle_tmd_image_url').$movie_info['backdrop_path'];

               $dbMovie->local_url_movie_image1 = $local_image_url1;

               $dbMovie->local_url_movie_image2 = $local_image_url2;

               $dbMovie->movie_type_movie_type_id = $this->show_type['movie'];

               $dbMovie->save(); 

               $movie_id = $dbMovie->movie_id;


               // Saves the movie´s description
               $dbMovieDescription = new MovieDescription();

               $dbMovieDescription->movie_description_name = $movie_info['title'];

               $dbMovieDescription->movie_description_description = $movie_info['overview'];

               $dbMovieDescription->movie_description_tagline = $movie_info['tagline'];

               $dbMovieDescription->language_id = $this->language_id;

               $dbMovieDescription->movie_id = $movie_id;

               $dbMovieDescription->save();

               

            }
            else{
                $theUrl     = config('app.guzzle_tmd_api_url').'/tv/'.$movie_id.'?api_key='.config('app.guzzle_tmd_api_key').'&language=pt-BR';

                $response   = Http ::get($theUrl);
                //var_dump($response);
                //
                if($response->getStatusCode()==200){
                    $movie_info =  $response->json();
                    $dbMovie = new Movie();

                    var_dump($movie_info);
                }
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
