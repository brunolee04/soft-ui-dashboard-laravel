<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SseController extends Controller{
    /**
     * Show Party function
     * @desc: In the waiting room, the system will check all the user´s that enjoied the party with token and gonna show then who enjoyed and how many users do it.
     * @param [type] $party_token
     * @return void
     */
    private $local_party_dir = "app\public\party";
    private $party_token = "";
    //public/party/U43W.json

    public function showParty($party_token){

            $this->party_token = $party_token;

            return response()->stream(function () {
            while (true) {
                    $file_name = storage_path($this->local_party_dir."\\".$this->party_token.".json");
                    
                    if(file_exists($file_name)){
                        $handle = fopen($file_name, "r");
                        $contents = fgets($handle);
                        fclose($handle);

                        echo "event: {$this->party_token}\n";
                        echo "data: {$contents}";
                        echo "\n\n";
                    }
                    

                    // $contents = Storage::get($file_name);
                    // if($contents!==NULL){
                       
                    // }

                    if (ob_get_contents()) ob_end_clean();
                        flush();
        
                        // Break the loop if the client aborted the connection (closed the page)
                        if (connection_aborted()) {break;}
                        usleep(50000); // 50ms
              
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);

    }


    public function stream(){
        return response()->stream(function () {
            while (true) {
                echo "event: ping\n";
                $curDate = date(DATE_ISO8601);
                echo 'data: {"time": "' . $curDate . '"}';
                echo "\n\n";

                $trades = Trade::latest()->get();
                echo 'data: {"total_trades":' . $trades->count() . '}' . "\n\n";

                $latestTrades = Trade::with('user', 'stock')->latest()->first();
                if ($latestTrades) {
                    echo 'data: {"latest_trade_user":"' . $latestTrades->user->name . '", "latest_trade_stock":"' . $latestTrades->stock->symbol . '", "latest_trade_volume":"' . $latestTrades->volume . '", "latest_trade_price":"' . $latestTrades->stock->price . '", "latest_trade_type":"' . $latestTrades->type . '"}' . "\n\n";
                }

                ob_flush();
                flush();

                // Break the loop if the client aborted the connection (closed the page)
                if (connection_aborted()) {break;}
                usleep(50000); // 50ms
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
    }
}
