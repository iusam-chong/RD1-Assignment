<?php

// --- 參考資料 ---
// https://ithelp.ithome.com.tw/articles/10224650

// --- 氣象局授權碼 --- 
// CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C

// --- 方法1 同源問題 ---
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
$obj = json_decode($json);
//print_r($obj) ;
// --- END ---

// --- 方法2 ---
// header('Access-Control-Allow-Origin: *'); 
// header("Content-Type: text/html; charset=utf-8");

// $text = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
// $tt = mb_convert_encoding($text, 'UTF-8',
//           mb_detect_encoding($text, 'UTF-8, big5', true));
//echo $tt;
// --- END ---


// # 縣市
// foreach($obj->records->location as $e ){
// echo $e->locationName. " | ";
// }

$userInput = "臺北市" ;

foreach ($obj->records->location as $loc ) {
    if ($loc->locationName == $userInput){
        echo $loc->locationName . "<hr>" ;
        // $element = $loc->locationName
        $element = $loc->weatherElement ; // weatherElement is an array
        break ;
    }
}

// # Wx | PoP | MinT | CI | MaxT , 天氣現象 | 最高溫度 | 最低溫度 | 舒適度 | 降雨幾率
// foreach($element as $e)
// echo $e->elementName . " | " ;

foreach ($element as $e) {
    echo $e->elementName . " <br> " ;
    foreach ($e->time as $t) {
        echo "startTime : ".$t->startTime ."<br>";
        echo "endTime : ".$t->endTime ."<br>";
        // echo "<br>parameterName : ".$t->parameter->parameterName ;
        // echo "<br>parameterValue : ".$t->parameter->parameterValue ; 
    }
}



?>
