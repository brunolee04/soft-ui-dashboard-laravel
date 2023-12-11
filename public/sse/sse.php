<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');


$file = '../../storage/app/public/party/8IOW.json';


while(true){
        $fpointer = fopen($file,'r');
        $string = fgets($fpointer);
        fclose($fpointer);
        // infinite loop
  
        // output the current timestamp; REPLACE WITH YOUR FUNCTIONALITY
        $time = date('H:m:s');
        echo "event: horario\n";
        echo "data: {$string}\n\n"; // 2 new line characters

        if (ob_get_contents()) ob_end_clean();
        flush();
        sleep(1); // wait for 2 seconds
   
}
