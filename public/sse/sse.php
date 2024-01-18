<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');


$file = '../../storage/app/public/party/8IOW.json';

function a($file){
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
        @ob_flush();@flush();
            
        // Break the loop if the client aborted the connection (closed the page)
        if (connection_aborted()) {break;}
        sleep(1);
   
}
}

function b($file){
        while(true){
       
                $handle = fopen($file, "w+");
                if(fwrite($handle,"xxx"))break;
                fclose($handle);
                if (ob_get_contents()) ob_end_clean();
                @ob_flush();@flush();
                    
                // Break the loop if the client aborted the connection (closed the page)
                if (connection_aborted()) {break;}
                sleep(1/2);
           
        }
}

if(isset($_GET['a']))a($file);
else if(isset($_GET['b']))b($file);
