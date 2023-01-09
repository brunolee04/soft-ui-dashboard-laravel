<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller{

    public function getMovies() {
        // logic to get all students goes here
        return response()->json([
            "message" => "student record created"
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
