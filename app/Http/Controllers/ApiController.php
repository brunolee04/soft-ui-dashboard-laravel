<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller{

    public function getMovies() {
        $db_movie_info = DB::table('movie')
        ->join('movie_description', 'movie.movie_id', '=', 'movie_description.movie_id')
        ->get();

        return response()->json([
            "status"  => true,
            "data"    => $db_movie_info
        ], 201);
      }
  
      public function createStudent(Request $request) {
        // logic to create a student record goes here
      }
  
      public function getMovie($id) {
        // logic to get a student record goes here
      }
  
      public function updateStudent(Request $request, $id) {
        // logic to update a student record goes here
      }
  
      public function deleteStudent ($id) {
        // logic to delete a student record goes here
      }
}
