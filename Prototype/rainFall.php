<?php

require_once('configdb.php') ;

$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&format=JSON&elementName=RAIN,HOUR_24&parameterName=CITY,TOWN,ATTRIBUTE') ;
$obj = json_decode($json) ;

//print_r($obj) ;

// @$db = setupDb() ;
// $command = <<< sqlDoc
// TRUNCATE TABLE `RainFall` 
// sqlDoc ;
// exec($command) ;

// $command = <<< sqlDoc
// INSERT INTO `RainFall` (
//     `stationName`, `dataDate`, `precipitation`)
//     VALUES (
//     :stationName, :dataDate, :precipitation)
// sqlDoc ;
// $cmd = $db->prepare($command) ;


foreach ($obj->records->location as $l ) {
    //echo $l->station->stationName."<hr>" ;

    //$cmd->bindValue(":stationName", $l->station->stationName);
    foreach ($l->weatherElement as $w) {

        echo $w->elementName . " | " .  $w->elementValue . "<br>" ;
        //$cmd->bindValue(":dataDate", $s->dataDate);
        // echo $s->weatherElements->precipitation. "<br>" ;
        //$cmd->bindValue(":precipitation", $s->weatherElements->precipitation);
        
        //$cmd->execute();
    }
    foreach ($l->parameter as $p) {
        
        echo $p->parameterName . " | " .  $p->parameterValue . "<br>" ;
    }

    
    echo "<hr>" ;
}
$db = NULL ;
?>