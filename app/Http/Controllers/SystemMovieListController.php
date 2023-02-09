<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\SystemMovieList;
use App\Models\SystemMovieListDescription;
use App\Models\MovieToSystemList;

class SystemMovieListController extends Controller{

    private $language_id = 0;

    private $shows;
    //

    public function listOfSystemLists(){    
        $this->language_id = config('app.language_id');

        $systemLists = DB::table('system_list')
        ->join('system_list_description', 'system_list.system_list_id', '=', 'system_list_description.system_list_id')
        ->where('system_list_description.language_id', $this->language_id)
        ->orderBy('system_list_description.system_list_description_name')
        ->get();
        return view('system_list/list',['systemLists'=>$systemLists]);
    }


    public function register(){

        $this->language_id = config('app.language_id');

        $shows = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->where('movie_description.language_id', $this->language_id)
        ->orderBy('movie_description.movie_description_name')
        ->get();

        $this->shows = $shows;
        return view('system_list/register',['shows'=>$shows]);
    }



    public function save(Request $request){
        
        $this->language_id = config('app.language_id');

        $system_list_description_name = $request->input('system_list_description_name');

        $system_list_date_avaiability = $request->input('system_list_date_avaiability');

        $system_list_description = $request->input('system_list_description');

        $shows_to_save = [];
      

        $shows = DB::table('movie')->get();

        foreach($shows as $show){
            if($request->input('movie_'.$show->movie_id)) $shows_to_save[] = $request->input('movie_'.$show->movie_id);
        }

        $dbSystemList = new SystemMovieList();

        $dbSystemListDescription = new SystemMovieListDescription();

        $dbSystemList->system_list_date_added = date('Y-m-d');

        $dbSystemList->system_list_date_avaiability = $system_list_date_avaiability;

        $dbSystemList->save();

        $systemListId = $dbSystemList->system_list_id;

        $dbSystemListDescription->system_list_description_name = $system_list_description_name;


        $dbSystemListDescription->system_list_description = $system_list_description;

        $dbSystemListDescription->system_list_id = $systemListId;

        $dbSystemListDescription->language_id = $this->language_id;

        $dbSystemListDescription->save();

        

        foreach($shows_to_save as $movie_id){
            $dbMovieToSystemList = new MovieToSystemList();
            
            $dbMovieToSystemList->movie_id = $movie_id;
            $dbMovieToSystemList->system_list_id = $systemListId;

            $dbMovieToSystemList->save();
        }

        return redirect()->action(
            [SystemMovieListController::class, 'listOfSystemLists']
        );
        
    }
}
