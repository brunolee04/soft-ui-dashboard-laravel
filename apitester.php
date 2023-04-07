<?php
$url = 'http://127.0.0.1:8000/api/movie/markThisShowAsSaw';
$data = array(
 "show_id"=>1,
 "movie_season_id"=>1,
 "customer_id"=>1
);
$data_string = json_encode($data);
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER,
    array(
        'Content-Type:application/json',
        'Content-Length: ' . strlen($data_string)
    )
);

$result = curl_exec($ch);
curl_close($ch)
?>