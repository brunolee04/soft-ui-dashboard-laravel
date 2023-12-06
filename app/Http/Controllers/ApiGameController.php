<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\JoinParty;
use App\Models\GameParty;



class ApiGameController extends Controller{

      private $language_id = 1;

      private $local_party_dir = "public/party";

      private $party_keep_alive = 3600; //seconds

      public function getParty($token) {
        $db_party_info = DB::table('party')
        ->where('party.party_token','=',$token)
        ->get();


        return response()->json([
            "status"  => true,
            "data"    => $db_party_info
        ], 201);
      }


      private function checkIfTmpUserIsAlreadyInAParty($party_id,$tmp_user_id){

        $tmpUserToPartyInfo = DB::table('tmp_user_to_party')
        ->where('tmp_user_to_party.tmp_user_id','=',$tmp_user_id)
        ->where('tmp_user_to_party.party_id','=',$party_id)
        ->get();

        return $tmpUserToPartyInfo;
      }



      public function joinParty(Request $request){

        $inputs = $request->all();

        $response = [];

        $party_token = $inputs['party_token'];

        $mail        = $inputs['mail']; 

        $db_party_info = DB::table('party')
        ->where('party.party_token','=',$party_token)
        ->get();

        if($db_party_info){

          $db_party_info = json_decode(json_encode($db_party_info),true);

          $db_party_info = isset($db_party_info[0]) ? $db_party_info[0] : $db_party_info;

          $tmp_user_id = 1;

          $party_id = $db_party_info['party_id'];

          $dbJoinParty = new JoinParty();

          $tmpUserInAParty = $this->checkIfTmpUserIsAlreadyInAParty($db_party_info['party_id'],$tmp_user_id);

          if($tmpUserInAParty->count() == 0){

            $dbJoinParty->tmp_user_id = $tmp_user_id;

            $dbJoinParty->party_id = $party_id;

            $dbJoinParty->point_qty = 0;

            $dbJoinParty->save();

          }
 
        }







        $response['party_token'] = $party_token;


        return response()->json([
          "status"  => true,
          "data"    => $response
        ], 201);

      }

      /*
        @name: Creates Party
        @desc: Creates a party based on recieved token:
          # Checks if "token party " already exists
          # Saves the new token
          # Creates a token.json file to give the party feedback in Server Side Event
      */
      public function createsParty(Request $request){

        // 1 - Gets the Party´s token

        $inputs      = $request->all();

        $response    = [];

        $party_token = $inputs['party_token'];

        $game_id     = $inputs['game_id'];

        // 2 - Checks if token already exists

        $db_party_info = DB::table('party')
        ->where('party.party_token','=',$party_token)
        ->get();

        if($db_party_info->count() == 0 ){

          // 2.1 - If token doesn´t exist, so a new party is created

          $dbParty = new GameParty();

          $dbParty->party_token = $party_token;

          $dbParty->game_id     = $game_id;

          $dbParty->date_added  = date("Y-m-d H:m:i");

          $dbParty->save();

          $party_id = 1;

          // 2.2 - A new json file with token name is created

          $data = array(
            "token"     => $party_token,
            "party_id"  => $party_id,
            "keep_alive"=> $this->party_keep_alive,
            "data"      => []
          );
    
          Storage::disk($this->local_party_dir)->put("{$party_token}.json", json_encode($data));

        }


      }

      public function test(){
        $show=6;
        $season = 1;
        
        $this->generalRateToMovie($show,$season);
      }
      
      
}
