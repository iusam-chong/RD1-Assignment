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

# Return startTime and value by rows 
function getValueAndTime($locationName, $elementName, $table, $Time, $value){
    
    @$db = setupDb() ;
    
    $command = <<< sqlDoc
        SELECT $Time, $value FROM $table
        WHERE locationName = :locationName AND elementName = :elementName
    sqlDoc ;
    $cmd = $db->prepare($command) ;
    $cmd->bindValue(":locationName",$locationName) ;
    $cmd->bindValue(":elementName",$elementName) ;
    $cmd->execute();

    $row = $cmd->fetchAll();
    return $row ;
}

# Write sql command without repeat code
function sqlCommand($colName, $tableName ){
    $command = <<< sqlDoc
        SELECT DISTINCT $colName FROM $tableName
    sqlDoc ;
    return $command ;
}

########################### ModelWeek ################################

# Catch no-repeat location name from table and save to array
$command = sqlCommand("locationName", "Week") ;
$locationList = GetTableElement($command) ;

# Like above but is element
$command = sqlCommand("elementName", "Week") ;
$elementList = GetTableElement($command) ;

# (prototype) Pass elementList to locationList save in modelWeek array 
$modelWeek = array() ;
foreach ($locationList as $lKey => $lValue) {
    $obj = (object) ["locationName" => $lValue] ;
    $arr = [] ;
    foreach ($elementList as $eKey => $eValue) {
        $arr[] = (object) ["elementName" => $eValue] ;
        $obj->element = $arr ;
    }
    $modelWeek[] = $obj  ;
}

# (showcase) These code will help to see $modelWeek structure
// foreach($modelWeek as $v){
//     echo $v->locationName . "<br>" ;
//     foreach($v->element as $e){
//         echo $e->elementName . " | ";
//     } 
//     echo "<hr>";
// }

# Using mode array to add element time and value 
foreach($modelWeek as $m) {
   foreach($m->element as $e){
       
        $arrTime = array() ; 
        $getValue = getValueAndTime($m->locationName, $e->elementName, "Week", "startTime", "value") ;

        foreach ($getValue as $gv) {
            $row = array("startTime" => $gv['startTime'], "value" => $gv['value']) ;
            array_push($arrTime,$row) ;
        }
        $e->time = $arrTime ;
    }
}

########################### ModelTwoDay ################################

# Catch no-repeat location name from table and save to array
$command = sqlCommand("locationName", "twoDay") ;
$locationList = GetTableElement($command) ;

# Like above but is element
$command = sqlCommand("elementName", "twoDay") ;
$elementList = GetTableElement($command) ;

# Pass elementList to locationList save in modelTwoDay array 
$modelTwoDay = array() ;
foreach ($locationList as $lKey => $lValue) {
    $obj = (object) ["locationName" => $lValue] ;
    $arr = [] ;
    foreach ($elementList as $eKey => $eValue) {
        if($eValue == "MinT" || $eValue == "MaxT" || $eValue == "PoP12h")
            continue ;
        $arr[] = (object) ["elementName" => $eValue] ;
        $obj->element = $arr ;
    }
    $modelTwoDay[] = $obj  ;
}

# Using mode array to add element time and value 
foreach($modelTwoDay as $m) {
    foreach($m->element as $e) {
        
        $arrTime = array() ;

        # Db have two time col but different name and one of them must me NULL
        $thisTime = ($e->elementName == "T") ? "dataTime" : "startTime" ;

        $getValue = getValueAndTime($m->locationName, $e->elementName, "TwoDay", $thisTime, "value") ;
        
        foreach ($getValue as $gv) {
            
            $row = array("startTime" => $gv[$thisTime], "value" => $gv['value']) ;

            array_push($arrTime,$row) ;
        }
        $e->time = $arrTime ;
    }
 }
 
########################### OneDayHalf ################################
$modelToday = array() ;

# IMPORTANT! Onedayhalf table should change the col name consistent with other table
function getValueAndTimeToday($locationName, $elementName, $table, $Time, $value){
    
    @$db = setupDb() ;
    
    $command = <<< sqlDoc
        SELECT $Time, $value FROM $table
        WHERE location = :locationName AND elementName = :elementName
    sqlDoc ;
    $cmd = $db->prepare($command) ;
    $cmd->bindValue(":locationName",$locationName) ;
    $cmd->bindValue(":elementName",$elementName) ;
    $cmd->execute();

    $row = $cmd->fetchAll();
    return $row ;
}

# Catch no-repeat location name from table and save to array
$command = sqlCommand("location", "onedayhalf") ;
$locationList = GetTableElement($command) ;

# Like above but is element
$command = sqlCommand("elementName", "onedayhalf") ;
$elementList = GetTableElement($command) ;

# Pass elementList to locationList save in modelToday array 
$modelToday = array() ;
foreach ($locationList as $lKey => $lValue) {
    $obj = (object) ["locationName" => $lValue] ;
    $arr = [] ;
    foreach ($elementList as $eKey => $eValue) {
        if($eValue == "parameterUnit" || $eValue == "endTime")
            continue ;
        $arr[] = (object) ["elementName" => $eValue] ;
        $obj->element = $arr ;
    }
    $modelToday[] = $obj  ;
}

# Using mode array to add element time and value 
foreach($modelToday as $m) {
    foreach($m->element as $e) {
        
        $arrTime = array() ;

        # Db have two time col but different name and one of them must me NULL
        //$thisTime = ($e->elementName == "T") ? "dataTime" : "startTime" ;

        $getValue = getValueAndTimeToday($m->locationName, $e->elementName, "onedayhalf", "startTime", "parameterName") ;
        
        foreach ($getValue as $gv) {
            
            $row = array("startTime" => $gv["startTime"], "value" => $gv["parameterName"]) ;

            array_push($arrTime,$row) ;
            break ;
        }
        $e->time = $arrTime ;
    }
}
//print_r($modelToday) ;
?>