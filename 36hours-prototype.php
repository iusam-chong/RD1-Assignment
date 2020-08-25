<?php

require_once('configdb.php') ;

// function getChildElement($child) {
//     foreach ($child as $array){

//     }
// }

// CREATE TABLE `form` (
//     location varchar(20),     
//    elementName	varchar(10),     
//    startTime varchar(30),
//    endTime	varchar(30),
//    parameterName varchar(20),
//    parameterUnit varchar(20),
//    parameterValue varchar(20)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


# 抓氣象局API 各式為JSON
# 要更新時再開 不然連結太多次會被鎖
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

//$cmd = $db->prepare("INSERT INTO `form` (location,elementName,startTime,endTime,parameterName,parameterUnit,parameterValue) VALUES (:locationName,:elementName,:startTime,:endTime,:parameterName,:parameterUnit,:parameterValue)");
$cmd = $db->prepare("INSERT INTO `formV2` (`location`,`elementName`,`startTime`,`endTime`,`parameterName`,`parameterUnit`,`parameterValue`) VALUES (:locationName,:elementName,:startTime,:endTime,:parameterName,:parameterUnit,:parameterValue)");
// $cmd = $db->prepare("UPDATE `form` SET(location) VALUES (:locationName)") ;

foreach ($obj->records->location as $l ) {
    echo $l->locationName."<br>" ;
    $cmd->bindValue(":locationName", $l->locationName);
    // $cmd->execute();
    
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
                //echo $key . ":" . $item . "<br>" ;
                
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

                // get array last key in foreach 
                // https://stackoverflow.com/questions/1070244/how-to-determine-the-first-and-last-iteration-in-a-foreach-loop
                
            }
            $cmd->execute();
            echo "<hr>" ;
        }
    }
    
}



// INSERT locationName , elementName
?>