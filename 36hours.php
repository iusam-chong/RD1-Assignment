<?php

require_once('configdb.php') ;

$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
$obj = json_decode($json) ;

$db = setupDb() ;

//$tableLocation = $db->prepare("INSERT INTO `location` (`locationName`) VALUES (:locationName)") ; 

$findLocationId = $db->prepare("SELECT `locationId` FROM `location` WHERE `locationName` = :para") ;

// $tableWx = $db->prepare("INSERT INTO `Wx` (`locationId`,`startTime`,`endTime`,`parameterName`,`parameterValue`) VALUES (:locationId,:startTime,:endTime,:parameterName,:parameterValue)") ;
$tableWx = $db->prepare("INSERT INTO `Wx` (`locationId`,`startTime`,`endTime`) VALUES (:locationId,:startTime,:endTime") ;


// foreach ($obj->records->location as $l ) {
//     $tableLocation->bindValue(":locationName", $l->locationName);
//     $tableLocation->execute();
// }


foreach ($obj->records->location as $l ) {
    echo $l->locationName . "<br>" ;
    $findLocationId->bindValue(":para", $l->locationName);
    $findLocationId->execute() ;
    $row = $findLocationId->fetch() ;
    echo $row['locationId'] . "<br>";

    $tableWx->bindValue(":locationId", $row['locationId']) ;

    foreach ($l->weatherElement as $w) {

        if ($w->elementName == "Wx"){
            echo $w->elementName . "<br>" ;
            
            foreach ($w->time as $t) {
                echo $t->startTime . "<br>" ;
                $tableWx->bindValue(":startTime", $t->startTime) ;

                echo $t->endTime . "<br>" ;
                $tableWx->bindValue(":endTime", $t->endTime) ;
                
                foreach ($t->parameter as $key => $item) {
                    // if ($key == "parameterName") {
                    //     echo $key . " : " . $item . "<br>" ;
                    //     $tableWx->bindValue(":parameterName", $item) ;
                    // }
                    // else {
                    //     echo $key . " : " . $item . "<br>" ;
                    //     $tableWx->bindValue(":parameterValue", $item) ;
                    // }
                }
                echo $tableWx->execute() ;
            }
        }
    }
    echo "<hr>" ;
}

?>