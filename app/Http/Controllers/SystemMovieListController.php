<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemMovieListController extends Controller{

    private $language_id = 0;

    private $shows;
    //

    public function listOfSystemLists(){      
        return view('system_list/list');
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
        $system_list_description_name = $request->input('system_list_description_name');
        echo $system_list_description_name;
    }
}
