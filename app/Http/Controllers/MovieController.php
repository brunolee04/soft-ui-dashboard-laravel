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
use App\Models\Writer;
use App\Models\Keyword;
use App\Models\MovieCollection;
use App\Models\MovieVideo;


class MovieController extends Controller{
    //

    private $language_id = 0;

    private $show_type = array(
                                'movie' => 0,
                                'serie' => 1
                            );
                            

    public function list(){
        $this->language_id = config('app.language_id');

        $shows = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->where('movie_description.language_id', $this->language_id)
        ->orderBy('movie_description.movie_description_name')
        ->get();

        $this->shows = $shows;
        return view('movie/list',['shows'=>$shows]);
    }

    public function register(){
        return view('movie/register');
    }

    public function edit(Request $request){

        $this->language_id = config('app.language_id');

        $movie_id = $request->movie_id;

        $show = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->where('movie_description.language_id', $this->language_id)
        ->where('movie.movie_id', $movie_id)
        ->first();

        $show = json_decode(json_encode($show),true);

        var_dump($show);

        return view('movie/editer',$show);
    }


    private function getYearLaunch($dateString){        
        return date('Y', strtotime($dateString));
    }

    public function save(Request $request){
        $this->language_id = config('app.language_id');

        $api_movie_id = $movie_id = $request->input('movie_id');
        
        if($this->formValidation(array('movie_id'=>1))){

            $theUrl     = config('app.guzzle_tmd_api_url').'/movie/'.$movie_id.'?api_key='.config('app.guzzle_tmd_api_key').'&language=pt-BR&append_to_response=credits,videos,keywords';
            echo $theUrl;
            $response   = Http ::get($theUrl);
           

            if($response->getStatusCode()==200){

               $movie_info =  $response->json();

               $db_movie_info = DB::table('movie')
                        ->where('api_movie_id',$movie_info['id'])
                        ->first();

                $key = true;
                if(is_null($db_movie_info) && $key){
                    $dbMovie = new Movie();

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

                    $dbMovie->api_movie_id = $movie_info['id'];                
     
                    
     
     
                    $dbMovie->save(); 
     
                    $movie_id = $dbMovie->movie_id;
     
                    DB::table('movie_season')->insert([
                     'movie_id' => $movie_id,
                     'season' => 1
                     ]);
     
     
                    // Saves the movie´s description
                    $dbMovieDescription = new MovieDescription();
     
                    $dbMovieDescription->movie_description_name = $movie_info['title'];

                    $dbMovieDescription->movie_description_original_name = $movie_info['original_title'];
     
                    $dbMovieDescription->movie_description_description = $movie_info['overview'];
     
                    $dbMovieDescription->movie_description_tagline = $movie_info['tagline'];
     
                    $dbMovieDescription->language_id = $this->language_id;
     
                    $dbMovieDescription->movie_id = $movie_id;
     
                    $dbMovieDescription->save();
     
                    
                    //Dealling with movie´s gender
                    if(isset($movie_info['genres'])){
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
                    }
                     
                    //Dealling with movie´s productions company
                    if(isset($movie_info['production_companies'])){
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
                    }
                         
                    //Dealing with Credits
                     if(isset($movie_info['credits'])){
     
                         $credits = $movie_info['credits'];
                        
                         //Dealing with Cast
                         $cast = $credits['cast'];
     
                         foreach($cast as $actor){
     
                            // var_dump($actor);
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
                                 $actor_id = $actor_info->actor_id;
                             }
                             

                             $actor_to_movie_info = DB::table('actor_to_movie')
                             ->where('movie_id',$movie_id)
                             ->where('actor_id',$actor_id)
                             ->first();

                             if($actor['id']==8691){
                                var_dump($actor_to_movie_info);
                             }
     
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


                            //Dealing with Writers
                            if(strcmp(strtolower($component['department']),'writing')==0 ){

                                $writer_info = DB::table('writer')
                                ->where('api_writer_id',$component['id'])
                                ->first();

                                if(is_null($writer_info)){

                                    $dbWriter = new Writer();

                                    $dbWriter->writer_name = $component['name'];

                                    $dbWriter->api_writer_id = $component['id'];

                                    $dbWriter->save();

                                    $writer_id = $dbWriter->writer_id;
                                }
                                else $writer_id = $writer_info->writer_id;

                                $writer_to_movie_info = DB::table('writer_to_movie')
                                ->where('writer_id',$writer_id)
                                ->where('movie_id',$movie_id)
                                ->first();

                                if(is_null($writer_to_movie_info)){
                                    DB::table('writer_to_movie')->insert([
                                        'movie_id' => $movie_id,
                                        'writer_id' => $writer_id
                                    ]);
                                }
                            }




                           
                        }
                    }

                    //Dealing with Keywords
                    if(isset($movie_info['keywords'])){
                        
                        $keywords = $movie_info['keywords'];

                        $keywords = isset($keywords['keywords']) ? $keywords['keywords'] : $keywords;

                        foreach($keywords as $keyword){

                            $dBKeyword = new Keyword();
     
                            $keyword_info = DB::table('movie_key_word')->where('api_movie_key_word_id',$keyword['id'])->first();
        
                            if(is_null($keyword_info)){

                                $dBKeyword->api_movie_key_word_id = $keyword['id'];

                                $dBKeyword->keyword = $keyword['name'];

                                $dBKeyword->save();

                                $keyword_id = $dBKeyword->movie_key_word_id;
                            }
                            else $keyword_id = $keyword_info->movie_key_word_id;

                            DB::table('movie_key_word_to_movie')->insert([
                                'movie_id' => $movie_id,
                                'movie_key_word_id' => $keyword_id
                            ]);
                        }
                    }

                    //Dealing with Collections
                    if(isset($movie_info['belongs_to_collection'])){

                        $belongs_to_collection = $movie_info['belongs_to_collection'];
     
                        $movieCollection_info = DB::table('movie_collection')->where('api_movie_collection_id',$belongs_to_collection['id'])->first();
        
                        if(is_null($movieCollection_info)){

                            $dbMovieCollection = new MovieCollection();

                            $dbMovieCollection->api_movie_collection_id = $belongs_to_collection['id'];

                            $dbMovieCollection->movie_collection_name = $belongs_to_collection['name'];

                            $dbMovieCollection->movie_collection_image_url = config('app.guzzle_tmd_image_url').$belongs_to_collection['poster_path'];

                            $dbMovieCollection->save();

                            $movie_collection_id = $dbMovieCollection->movie_collection_id;
                        }
                        else $movie_collection_id = $movieCollection_info->movie_collection_id;

                        DB::table('movie_to_movie_collection')->insert([
                                'movie_id' => $movie_id,
                                'movie_collection_id' => $movie_collection_id
                            ]);
                        
                    }

                    //Dealing with Videos
                    if(isset($movie_info['videos'])){
                        $videos = $movie_info['videos'];

                        $videos = isset($videos['results']) ? $videos['results'] : $videos;

                        foreach($videos as $video){

                            $dbVideo = new MovieVideo();
     
                            $video_info = DB::table('movie_video')->where('api_movie_video_id',$keyword['id'])->first();
        
                            if(is_null($video_info)){

                                $date_published_at = $video['published_at'];

                                $date_published_at = strpos($date_published_at,'T')!==false? explode('T',$date_published_at) : $date_published_at;

                                $date_published_at = $date_published_at[0];

                                $dbVideo->api_movie_video_id = $video['id'];

                                $dbVideo->movie_video_site = $video['site'];

                                $dbVideo->movie_video_key = $video['key'];

                                $dbVideo->movie_video_iso_639_1 = $video['iso_639_1'];

                                $dbVideo->movie_video_iso_3166_1 = $video['iso_3166_1'];

                                $dbVideo->movie_video_type = $video['type'];

                                $dbVideo->movie_video_official = $video['official'];

                                $dbVideo->movie_video_published_at = $date_published_at;

                                $dbVideo->movie_id = $movie_id;

                                $dbVideo->save();

                                $movie_video_id = $dbVideo->movie_video_id;
                            }
                            else $movie_video_id = $video_info->movie_video_id;

                            DB::table('movie_video_description')->insert([
                                'movie_video_id' => $movie_video_id,
                                'movie_video_name' => $video['name'],
                                'language_id' => $this->language_id
                            ]);
                        }


                    }

                    //Dealing with Movie Watch Providers
                    $watch_providers = $this->getMovieWatchProviders($api_movie_id);

                    

                }
                
                // return redirect()->action(
                //     [MovieController::class, 'edit'], ['movie_id'=>$movie_id]
                // );
               

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



    private function getMovieWatchProviders($id){

        $locale = "BR";

        $theUrl     = config('app.guzzle_tmd_api_url').'/movie/'.$movie_id.'/watch/providers?api_key='.config('app.guzzle_tmd_api_key');

        $response   = Http ::get($theUrl); 
        
        $providers_package = [];

            if($response->getStatusCode()==200){

               $watch_providers =  $response->json();

               $watch_providers = json_decode($watch_providers,true);

                foreach($watch_providers as $watch_provider){

                    $providers_package = isset($watch_providers[$locale])?$watch_providers[$locale]:null;

                }
            }
        
        return $providers_package;

    }

    private function formValidation($rules){
        $countErrors = 0 ;

        foreach($rules as $field_name => $value){

            if(strlen($field_name)<$value)$countErrors++;
        }

        return $countErrors > 0 ? false : true;
    }
}
