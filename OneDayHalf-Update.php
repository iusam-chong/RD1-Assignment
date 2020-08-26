<?php
require_once('configdb.php') ;

# 抓氣象局API 各式為JSON
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
$obj = json_decode($json) ;

@$db = setupDb() ;

$command = <<< sqlDoc
    UPDATE `OneDayHalf` 
        SET `location` = :locationName, 
            `elementName` = :elementName, 
            `startTime` = :startTime, 
            `endTime` = :endTime, 
            `parameterName` = :parameterName, 
            `parameterUnit` = :parameterUnit, 
            `parameterValue` = :parameterValue 
        WHERE `id` = :dbIndex 
sqlDoc ;

$cmd = $db->prepare($command) ;

$dbIndex = 0 ;

foreach ($obj->records->location as $l ) {
    
    //echo $l->locationName."<br>" ;
    $cmd->bindValue(":locationName", $l->locationName);
  
    foreach ($l->weatherElement as $e ) {
        //echo $e->elementName."<br>" ;
        
        $cmd->bindValue(":elementName", $e->elementName);

        foreach ($e->time as $t) {
            //echo $t->startTime."<br>" ;
            //echo $t->endTime."<br>" ;

            $cmd->bindValue(":startTime", $t->startTime);
            $cmd->bindValue(":endTime", $t->endTime);
            
            $cmd->bindValue(":parameterName", "");
            $cmd->bindValue(":parameterUnit", "");
            $cmd->bindValue(":parameterValue", "");

            foreach ($t->parameter as $key => $item) {
                
                if($key == "parameterName"){
                    //echo $key ." : " ;
                    //echo $item . "<br>";
                    $cmd->bindValue(":parameterName", $item);
                }
                else if($key == "parameterUnit"){
                    //echo $key ." : " ;
                    //echo $item . "<br>";
                    $cmd->bindValue(":parameterUnit", $item);
                }
                else if($key == "parameterValue"){
                    //echo $key ." : " ;
                    //echo $item . "<br>";
                    $cmd->bindValue(":parameterValue", $item);
                } 
            }
            $dbIndex++ ;
            $cmd->bindValue(":dbIndex", $dbIndex) ; 
            @$cmd->execute() ;
        }
    }
}
?>


