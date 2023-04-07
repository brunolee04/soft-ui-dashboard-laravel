<?php
$url = 'https://codevalley.dev/api/movie/markThisShowAsSaw';
$data = '{
    show_id:showId,
    movie_season_id:1,
    customer_id:1
  }';
$data_string = $data;
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