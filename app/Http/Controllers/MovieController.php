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

    public function save(Request $request){
        $movie_url = $request->input('movie_url');
        echo $movie_url;

         $theUrl     = config('app.guzzle_tmd_api_url').'/example.json';
         $users   = Http ::get($theUrl);
         return $users;
    }
}
