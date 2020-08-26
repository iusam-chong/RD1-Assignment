<?php

$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
$obj = json_decode($json);

print_r($obj) ;
?>