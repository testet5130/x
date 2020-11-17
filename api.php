<?php

    $APIkey='3644d80ea8eba40461d7e84820d2a4ef9c9e9040981eeb9f5da5bc036191189d';

    if( isset($_GET["id"]) && !empty($_GET["id"]) ) {
        if(is_numeric($_GET["id"]) ) {
            $id = intval($_GET["id"])-1;
            $leaguesID = ["148", "468", "262", "196", "176", "144", "421", "338", "4", "509", "529"];

            if($id < count($leaguesID)) {

                $curl_options = array(
                    CURLOPT_URL => "https://apiv2.apifootball.com/?action=get_standings&league_id=".$leaguesID[$id]."&APIkey=$APIkey",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_CONNECTTIMEOUT => 5
                );
                
                $curl = curl_init();
                curl_setopt_array( $curl, $curl_options );
                $result = curl_exec( $curl );
                
                print_r($result);
            
            }
        }
    }


?>