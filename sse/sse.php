<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

while(true){
    // infinite loop
    while (1) {
        // output the current timestamp; REPLACE WITH YOUR FUNCTIONALITY
        $time = date('H:m:s');
        echo "event: horario\n";
        echo "data: {$time}\n\n"; // 2 new line characters

        if (ob_get_contents()) ob_end_clean();
        flush();
        sleep(1); // wait for 2 seconds
    }
}
