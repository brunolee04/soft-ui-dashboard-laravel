<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartyJsonCreator extends Controller{

    private $sse = array(
        "token"     => "",
        "party_id"  => 0,
        "keep_alive"=> 3600,
        "data"      => []
      );
    
    private $local_party_dir = "app\public\party";

    private $file_name = "";

    public function createJson($party_token,$party_id,$data = []){
        $this->sse["token"] = $party_token;
        $this->sse["party_id"] = $party_id;
        $this->sse["data"] = $data;

        return $this->sse;
    }

    public function updateJson($party_token,$party_id,$data){
        $this->sse["token"] = $party_token;
        $this->sse["party_id"] = $party_id;
        $this->sse["data"] = $data;

        $file_name = storage_path($this->local_party_dir."\\".$party_token.".json");

        return $this->writeFile($file_name);
    }

    public function writeFile($file_name){

        $this->file_name = $file_name;

        return response()->stream(function () {
            if(file_exists($this->file_name)){
                while(true){
                    $handle = fopen($this->file_name, "w+");
                    if(fwrite($handle,json_encode($this->sse)))break;
                    fclose($handle);
                }
               
                return true;
            }
            else return false;
            
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
    }
}
