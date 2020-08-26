<?php

    $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=MinT,MaxT,PoP12h,Wx') ;
    $obj = json_decode($json) ;

    $command = <<< sqlDoc
    UPDATE `Week` 
        SET `locationName` = :locationName,
            `elementName` = :elementName,
            `startTime` = :startTime,
            `endTime` = :endTime,
            `dataTime` = :dataTime,
            `value` = :value,
            `measures` = :measures
        WHERE `id` = :dbIndex
    sqlDoc ;

?>