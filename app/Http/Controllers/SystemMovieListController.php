<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemMovieListController extends Controller{
    //

    public function listOfSystemLists(){
        return view('system_list/list');
    }

    public function register(){
        return view('system_list/register');
    }
}
