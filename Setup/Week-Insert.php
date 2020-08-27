<?php

/*
12小時降雨機率 | PoP12h
天氣現象 | Wx
最低溫度 | MinT
最高溫度 | MaxT
*/

# 未來1週預報部分屬性抓取
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=MinT,MaxT,PoP12h,Wx') ;
$obj = json_decode($json) ;

@$db = setupDb() ;

$command = <<< sqlDoc
INSERT INTO `Week` (
    `locationName`, `elementName`, `startTime`, `endTime`, `dataTime`, `value`, `measures`)
    VALUES (
    :locationName, :elementName, :startTime, :endTime, :dataTime, :value, :measures)
sqlDoc ;
$cmd = $db->prepare($command) ;

foreach ($obj->records->locations as $ls ) {
    
    foreach ($ls->location as $l){
        
        echo $l->locationName . "<br>" ;
        $cmd->bindValue(":locationName", $l->locationName);

        foreach ($l->weatherElement as $e) {
            
            # 查看屬性 echo $e->description ;
            echo $e->elementName . " | " ;
            $cmd->bindValue(":elementName", $e->elementName);

            $cmd->bindValue(":startTime", "");
            $cmd->bindValue(":endTime", "");
            $cmd->bindValue(":dataTime", "");

            foreach ($e->time as $t) {
                
                if (isset($t->startTime)){
                    echo $t->startTime . " - " ;
                    $cmd->bindValue(":startTime", $t->startTime);
                }
                if (isset($t->endTime)){
                    echo $t->endTime . "<br>" ;
                    $cmd->bindValue(":endTime", $t->endTime);
                }
                if (isset($t->dataTime)){
                    echo $t->dataTime . "<br>" ;
                    $cmd->bindValue(":dataTime", $t->dataTime);
                }

                $cmd->bindValue(":value", "");
                $cmd->bindValue(":measures", "");

                foreach ($t->elementValue as $v) {
                    
                    echo $v->value . " " ;
                    $cmd->bindValue(":value", $v->value);

                    echo $v->measures . "<br>" ;
                    $cmd->bindValue(":measures", $v->measures);
                }
                $cmd->execute();
                echo "<br>" ;
            }
            echo "<hr>" ;
        }
        // break ; // 只測試一縣市就先停在這裏
    }     
}
$db = NULL ;
?>
