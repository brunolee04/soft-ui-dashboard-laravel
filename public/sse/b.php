<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');


$file = '../../storage/app/public/party/8IOW.json';



while(true){
        $fpointer = fopen($file,'w+');
        fwrite($fpointer,'{"token":"8IOW","party_id":2,"keep_alive":3600,"data":["xablau":"FSADFASDF"]}');
        fclose($fpointer);
        // infinite loop
  
        
        if (ob_get_contents()) ob_end_clean();
        flush();
        sleep(1); // wait for 2 seconds
   
}
