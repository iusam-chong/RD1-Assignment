<?php
    //require_once('/configdb.php') ;

    # 抓氣象局API 各式為JSON
    $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C');
    $obj = json_decode($json) ;
    
    print_r($obj) ;

    //@$db = setupDb() ;

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
    # wx T

    // foreach ($obj->records->locations as $ls ) {
        
    //     foreach ($ls->location as $l){

    //         echo $l->locationName . "<br>" ;

    //         foreach ($l->weatherElement as $e) {
                
    //             echo $e->elementName . " | " ;
    //             echo $e->description . "<br>" ;

    //             foreach ($e->time as $t) {
                    
    //                 if (isset($t->startTime)){
    //                     echo $t->startTime . " - " ;
    //                 }
    //                 if (isset($t->endTime)){
    //                     echo $t->endTime . "<br>" ;
    //                 }
    //                 if (isset($t->dataTime)){
    //                     echo '=D' ;
    //                 }

    //                 foreach ($t->elementValue as $v) {
                        
    //                     echo $v->value . " " ;
    //                     echo $v->measures . "<br>" ;
    //                 }
                    
    //             }
    //             echo "<hr>" ;
    //         }
            
    //     }     
    // }

?>