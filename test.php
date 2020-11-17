<?php

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $data = [
    "season_id" => "4",
    ];

    curl_setopt($ch, CURLOPT_URL, "https://app.sportdataapi.com/api/v1/soccer/topscorers?" . http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "apikey: 533add00-24fe-11eb-a333-752404677ace",  
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);

    var_dump($json);
    
?>