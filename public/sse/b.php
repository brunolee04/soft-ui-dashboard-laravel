<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');


$file = '../../storage/app/public/party/8IOW.json';



while(true){
       
        $handle = fopen($file, "w+");
        if(fwrite($handle,"aaaa"))break;
        fclose($handle);
        if (ob_get_contents()) ob_end_clean();
        @ob_flush();@flush();
            
        // Break the loop if the client aborted the connection (closed the page)
        if (connection_aborted()) {break;}
        sleep(1/2);
   
}
