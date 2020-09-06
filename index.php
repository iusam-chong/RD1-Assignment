<?php

require_once('./includes/class-autoload.php');

$weather = new WeatherContr();

$update = $weather->updateWeather();

// $week = $weather->constructWeek();
// $twoDay = $weather->constructTwoDay();
// $oneDay = $weather->constructOneDay();

// week
// $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=MinT,MaxT,PoP12h,Wx') ;
// $obj = json_decode($json) ;
// echo "week <hr>";

// twoday
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=Wx,PoP12h,T&sort=time') ;
$obj = json_decode($json) ;
//echo "twoday <hr>";
$obj = $obj->records->locations['0']->location;

// 36H
// $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
// $obj = json_decode($json) ;
// echo "36H <hr>";
// $obj = $obj->records->location;

// print_r($obj);

// die();

//foreach ($obj->records->locations as $ls ) {
    
    //foreach ($ls->location as $l){
    // foreach ($obj as $l){

    //     echo $l->locationName . "<hr>";

    //     foreach ($l->weatherElement as $e) {
         
    //         echo $e->elementName . " <br>";
           
    //         foreach ($e->time as $t) {
                
    //             $getTime = (isset($t->startTime)) ? $t->startTime : $t->dataTime;
    //             //$day = substr($time,5,5);
    //             $getDay = substr($getTime,0,10);
    //             $getHour = substr($getTime,11,2);

    //             $today = date("Y-m-d") ;
    //            // echo $day . " | " . $today . "<br>";

    //             # if getDay biggest than today, that means getDay not today
    //             if ($getDay > $today ) {
                    
    //                 # we just want 2days data, more than 2days we skip
    //                 $now = new DateTime($today);
    //                 $later = new DateTime($getDay);
    //                 $diff = $later->diff($now)->format("%a");

    //                 if ($diff > 2){
    //                     continue;
    //                 }
    //             }   else {

    //                 # if day is today, we dont need these data, so skip this loop
    //                 continue;
    //             }

    //             if ($getHour == 18 || $getHour == 6){
                    
    //             } else {
    //                 continue;
    //             }
                
    //             # if code above can run until here ,do something here
    //             echo  $getDay."|".$getHour."| ";
             
    //             foreach ($t->elementValue as $v) {

    //                 if (!is_numeric($v->value))
    //                     continue ;

    //                 echo  $v->value . " |";
    //                 echo  $v->measures . " |";
    //                // print_r($v);
    //             }
    //             echo "<hr>";
    //         }
    //     }
    //     break;
    // }     
//}


?>