<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function save(Request $request){
        $movie_id = $request->input('movie_id');
        
        if($this->formValidation(array('movie_id'=>1))){

            $theUrl     = config('app.guzzle_tmd_api_url').'/movie/'.$movie_id.'?api_key='.config('app.guzzle_tmd_api_key');

            $users   = Http ::get($theUrl);
            
            return $users;
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
