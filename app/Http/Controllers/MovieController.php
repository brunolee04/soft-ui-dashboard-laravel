<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\MovieGenderController;

use App\Models\Movie;
use App\Models\MovieDescription;
use App\Models\MovieGender;
use App\Models\ProductionCompany;
use App\Models\Actor;
use App\Models\Director;


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

            $theUrl     = config('app.guzzle_tmd_api_url').'/movie/'.$movie_id.'?api_key='.config('app.guzzle_tmd_api_key').'&language=pt-BR&append_to_response=credits';

            $response   = Http ::get($theUrl);
           
            //
            if($response->getStatusCode()==200){

               $movie_info =  $response->json();

               $db_movie_info = DB::table('movie')
                        ->where('api_movie_id',$movie_info['id'])
                        ->first();
            
                if(is_null($db_movie_info)){
                    $dbMovie = new Movie();

                    $movie_image_1 = config('app.guzzle_tmd_image_url').$movie_info['poster_path'];
     
                    $movie_image_1_parts = explode('/', $movie_image_1);
     
                    $local_image_url1 = config('app.local_image_url').'/movie/'.end($movie_image_1_parts); 
     
                   // Storage::disk('local')->put(config('app.local_movie_image_url').end($movie_image_1_parts), file_get_contents($movie_image_1));
     
     
                    $movie_image_2 = config('app.guzzle_tmd_image_url').$movie_info['backdrop_path'];
                    
                    $movie_image_2_parts = explode('/', $movie_image_2);
     
                    $local_image_url2 = config('app.local_image_url').'/movie/'.end($movie_image_2_parts); 
     
                   // Storage::disk('local')->put(config('app.local_movie_image_url').end($movie_image_2_parts), file_get_contents($movie_image_2));
     
     
     
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
     
                    DB::table('movie_season')->insert([
                     'movie_id' => $movie_id,
                     'season' => 1
                     ]);
     
     
                    // Saves the movie´s description
                    $dbMovieDescription = new MovieDescription();
     
                    $dbMovieDescription->movie_description_name = $movie_info['title'];
     
                    $dbMovieDescription->movie_description_description = $movie_info['overview'];
     
                    $dbMovieDescription->movie_description_tagline = $movie_info['tagline'];
     
                    $dbMovieDescription->language_id = $this->language_id;
     
                    $dbMovieDescription->movie_id = $movie_id;
     
                    $dbMovieDescription->save();
     
                    
                     //Dealling with movie´s gender
                     $genres = $movie_info['genres'];
     
                     foreach($genres as $genre){
                         
                         $dbMovieGender = new MovieGender();
     
                         $movie_gender_info = DB::table('movie_gender')->where('api_gender_id',$genre['id'])->first();
     
                         if(is_null($movie_gender_info)){
     
                             $dbMovieGender->language_id       = $this->language_id;
     
                             $dbMovieGender->movie_gender_name = $genre['name'];
     
                             $dbMovieGender->api_gender_id     = $genre['id'];
     
                             $dbMovieGender->save();
     
                             $movie_gender_id = $dbMovieGender->movie_gender_id;
        
                         }
                         else{
                             $movie_gender_id = $movie_gender_info->movie_gender_id;
                         }
     
                         DB::table('movie_to_movie_gender')->insert([
                             'movie_id' => $movie_id,
                             'movie_gender_id' => $movie_gender_id
                         ]);
                         
                     }
     
     
     
                     //Dealling with movie´s productions company
                     $production_companies = $movie_info['production_companies'];
     
                     foreach($production_companies as $production_company){
                         
                         $dbProductionCompany = new ProductionCompany();
     
                         $production_company_info = DB::table('production_company')->where('api_production_company_id',$production_company['id'])->first();
     
                         if(is_null($production_company_info)){
     
                             $dbProductionCompany->production_company_name = $production_company['name'];
     
                             $dbProductionCompany->production_companies_logo_url = config('app.guzzle_tmd_image_url').$production_company['logo_path'];
     
                             $dbProductionCompany->api_production_company_id = $production_company['id'];
     
                             $dbProductionCompany->save();
     
                             $production_company_id = $dbProductionCompany->production_company_id;
        
                         }
                         else{
                             $production_company_id = $dbProductionCompany->production_company_id;
                         }
     
                         DB::table('movie_to_production_company')->insert([
                             'movie_id' => $movie_id,
                             'production_company_id' => $production_company_id
                         ]);
                         
                     }
     
                     //Dealing with Credits
                     if(isset($movie_info['credits'])){
     
                         $credits = $movie_info['credits'];
                        
                         //Dealing with Cast
                         $cast = $credits['cast'];
     
                         foreach($cast as $actor){
     
                             var_dump($actor);
                             $dbActor = new Actor();
     
                             $actor_info = DB::table('actor')->where('api_actor_id',$actor['id'])->first();
     
                             if(is_null($actor_info)){
     
                                 $dbActor->actor_gender = $actor['gender'];
     
                                 $dbActor->actor_image_url = config('app.guzzle_tmd_image_url').$actor['profile_path'];
     
                                 $dbActor->actor_name = $actor['name'];
     
                                 $dbActor->api_actor_id = $actor['id'];
     
                                 $dbActor->save();
     
                                 $actor_id = $dbActor->actor_id;
         
                             }
                             else{
                                 $actor_id = $dbActor->actor_id;
                             }
     
                             $actor_to_movie_info = DB::table('actor_to_movie')
                             ->where('movie_id',$movie_id)
                             ->where('actor_id',$actor_id)
                             ->first();
     
                             if(is_null($actor_to_movie_info)){
                                 DB::table('actor_to_movie')->insert([
                                     'movie_id' => $movie_id,
                                     'actor_id' => $actor_id,
                                     'actor_character' => $actor['character']
                                 ]);
                             }
                         }


                         //Desling with Directors and Writers
                         $crew = $credits['crew'];

                        foreach($crew as $component){

                            //Dealing with Directors
                            if(strcmp(strtolower($component['department']),'directing')==0 && strcmp(strtolower($component['job']),'director')==0){

                                $director_info = DB::table('director')
                                ->where('api_director_id',$component['id'])
                                ->first();

                                if(is_null($director_info)){

                                    $dbDirector = new Director();

                                    $dbDirector->director_name = $component['name'];

                                    $dbDirector->director_image_url = config('app.guzzle_tmd_image_url').$component['profile_path'];

                                    $dbDirector->api_director_id = $component['id'];

                                    $dbDirector->save();

                                    $director_id = $dbDirector->director_id;
                                }
                                else $director_id = $director_info->director_id;

                                $director_to_movie_info = DB::table('director_to_movie')
                                ->where('director_id',$director_id)
                                ->where('movie_id',$movie_id)
                                ->first();

                                if(is_null($director_to_movie_info)){
                                    DB::table('director_to_movie')->insert([
                                        'movie_id' => $movie_id,
                                        'director_id' => $director_id
                                    ]);
                                }
                            }
                           
                        }
                     }
                }
              
                

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
