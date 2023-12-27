<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');


$file = '../../storage/app/public/party/8IOW.json';


while(true){
        // $fpointer = fopen($file,'r');
        // $string = fgets($fpointer);
        // fclose($fpointer);
        // infinite loop
        $string = "invoca";
        // output the current timestamp; 
        $time = date('H:m:s');
        echo "event: horario\n";
        echo "data: {$string}\n\n"; // 2 new line characters

        if (ob_get_contents()) ob_end_clean();
        flush();
        // Break the loop if the client aborted the connection (closed the page)
        if (connection_aborted()) {break;}
        usleep(50000); // 50ms
}
