<?php

# 抓氣象局API 各式為JSON
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
$obj = json_decode($json) ;

// $json = file_get_contents('fadeAddress.txt');
// $obj = json_decode($json) ;

# 檔案結構
# OBJ->records->location[locationName]
# OBJ->records->location->weatherElement[elementName]
# OBJ->records->location->weatherElement->time->startTime / time->endTime
# OBJ->records->location->weatherElement->time->parameter[parameterName,parameterUnit / parameterValue]

$db = setupDb() ;

$cmd = $db->prepare("INSERT INTO `OneDayHalf` (`location`,`elementName`,`startTime`,`endTime`,`parameterName`,`parameterUnit`,`parameterValue`) VALUES (:locationName,:elementName,:startTime,:endTime,:parameterName,:parameterUnit,:parameterValue)");

foreach ($obj->records->location as $l ) {
    echo $l->locationName."<br>" ;
    $cmd->bindValue(":locationName", $l->locationName);
    
    foreach ($l->weatherElement as $e ) {
        echo $e->elementName."<br>" ;
        
        $cmd->bindValue(":elementName", $e->elementName);

        foreach ($e->time as $t) {
            echo $t->startTime."<br>" ;
            echo $t->endTime."<br>" ;

            $cmd->bindValue(":startTime", $t->startTime);
            $cmd->bindValue(":endTime", $t->endTime);
            
            $cmd->bindValue(":parameterName", "");
            $cmd->bindValue(":parameterUnit", "");
            $cmd->bindValue(":parameterValue", "");

            foreach ($t->parameter as $key => $item) {
                
                if($key == "parameterName"){
                    echo $key ." : " ;
                    echo $item . "<br>";
                    $cmd->bindValue(":parameterName", $item);
                }
                else if($key == "parameterUnit"){
                    echo $key ." : " ;
                    echo $item . "<br>";
                    $cmd->bindValue(":parameterUnit", $item);
                }
                else if($key == "parameterValue"){
                    echo $key ." : " ;
                    echo $item . "<br>";
                    $cmd->bindValue(":parameterValue", $item);
                } 
            }
            $cmd->execute();
            echo "<hr>" ;
        }
    }
    
}
$db = NULL ;
?>