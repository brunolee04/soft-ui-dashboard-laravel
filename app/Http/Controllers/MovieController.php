<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller{
    //

    public function list(){
        return view('movie/list');
    }

    public function register(){
        return view('movie/register');
    }

    public function save(Request $request){
        va
    }
}
