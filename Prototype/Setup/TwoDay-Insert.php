<?php
# 未來2天預報 全屬性一覽
# wx | 天氣現象 
# AT | 體感溫度 
# T  | 溫度
# RH | 相對濕度 
# CI | 舒適度指數 
# WeatherDescription | 天氣預報綜合描述
# PoP6h  | 6小時降雨機率
# PoP12h | 12小時降雨機率
# WS | 風速 
# WD | 風向 
# Td | 露點溫度

# 程式使用屬性
# wx T PoP6h

# 抓氣象局API 各式為JSON
# 未來2天預報全屬性抓取
# $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');

# 未來2天預報部分屬性抓取
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=Wx,T,PoP6h') ;
$obj = json_decode($json) ;

@$db = setupDb() ;

$command = <<< sqlDoc
INSERT INTO `TwoDay` (
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