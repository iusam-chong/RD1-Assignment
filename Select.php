<?php

require_once('ConfigDb.php') ;

# Get table row and save it each to array, then return it
function GetTableElement($command){
    @$db = setupDb() ;
    $cmd = $db->prepare($command) ;
    $cmd->execute();
    $row = $cmd->fetchAll();

    $arr = array() ;
    # IMPORTANT: fetch() can't get all the row, but fetchAll() can
    # however will catch double array in an array layer 
    foreach($row as $row2){
        foreach($row2 as $key => $value){
            $arr[] = $value ;
            break ;
        }
    }
    $db = NULL ;
    return $arr ;
}

# Catch no-repeat location name from table and save to array
$command = <<< sqlDoc
    SELECT DISTINCT locationName FROM week
sqlDoc ;
$locationList = GetTableElement($command) ;

# Like above but is element
$command = <<< sqlDoc
    SELECT DISTINCT ElementName FROM week
sqlDoc ;
$elementList = GetTableElement($command) ;

# (prototype) Pass elementList to locationList save in model array 
// $model = array() ;
// foreach ($locationList as $lKey => $lValue) {
//     $obj = (object) ["locationName" => $lValue] ;
//     $arr = [] ;
//     foreach ($elementList as $eKey => $eValue) {
//         $arr[] = (object) ["elementName" => $eValue] ;
//         $obj->element = $arr ;
//     }
//     $model[] = $obj  ;
// }

# (prototype) These code will help to see $model structure
// foreach($model as $v){
//     echo $v->locationName . "<br>" ;
//     foreach($v->element as $e){
//         echo $e->elementName . " | ";
//     } 
//     echo "<hr>";
// }

$model = array() ;
foreach ($locationList as $lKey => $lValue) {
    $obj = (object) ["locationName" => $lValue] ;
    $arr = [] ;
    foreach ($elementList as $eKey => $eValue) {
        $arr[] = (object) ["elementName" => $eValue] ;
        $obj->element = $arr ;
    }
    $model[] = $obj  ;
}
//print_r($model) ;

//$cmd = $db->prepare($command) ;

// $command = <<< sqlDoc
// SELECT COUNT('value') FROM `week` WHERE locationName = '雲林縣' AND elementName = 'Wx'
// sqlDoc ;
// @$db = setupDb() ;
// $cmd = $db->prepare($command) ;
// $cmd->execute();
// $row = $cmd->fetch();
// print_r($row) ;

$row = countValueRow("雲林縣", "Wx") ;
echo $row ;

function countValueRow($locationName, $elementName){
    
    @$db = setupDb() ;
    
    $command = <<< sqlDoc
        SELECT COUNT('value') FROM `week` 
        WHERE locationName = :locationName AND elementName = :elementName
    sqlDoc ;
    $cmd = $db->prepare($command) ;
    $cmd->bindValue(":locationName",$locationName) ;
    $cmd->bindValue(":elementName",$elementName) ;
    $cmd->execute();

    $row = $cmd->fetch();
    return $row["COUNT('value')"] ;
}

// $command = <<< sqlDoc
// SELECT `startTime`, `value`
//     FROM `Week` 
//     WHERE  `locationName` = "" AND `elementName` = "PoP12h"
// sqlDoc ;

// @$db = setupDb() ;
// $cmd = $db->prepare($command) ;

?>