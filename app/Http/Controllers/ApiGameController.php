<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\CustomerRatesMovie;
use App\Models\Movie;
use App\Models\MovieSeason;


class ApiGameController extends Controller{

      private $language_id = 1;

      public function getParty($token) {
        $db_party_info = DB::table('party')
        ->where('party.party_token','=',$token)
        ->get();

        return response()->json([
            "status"  => true,
            "data"    => $db_party_info
        ], 201);
      }

      public function joinParty(Request $request){

        $inputs = $request->all();

        $response = [];

        $party_token = $inputs['party_token'];

      }

      public function test(){
        $show=6;
        $season = 1;
        
        $this->generalRateToMovie($show,$season);
      }
      
      
}
