<?php

$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/C-B0025-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C') ;
$obj = json_decode($json) ;

# VALUE T = 1 > 0.1

foreach ($obj->records->location as $l ) {
    echo $l->station->stationName."<hr>" ;
    foreach ($l->stationObsTimes->stationObsTime as $s) {

        echo $s->dataDate. " | " ;
        echo $s->weatherElements->precipitation. "<br>" ;
    }
}
?>