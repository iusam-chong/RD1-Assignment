<?php

@$db = setupDb() ;
$cmd = $db->prepare($command) ;
$dbIndex = 0 ;

foreach ($obj->records->locations as $ls ) {
    
    foreach ($ls->location as $l){
        
        //echo $l->locationName . "<br>" ;
        $cmd->bindValue(":locationName", $l->locationName);

        foreach ($l->weatherElement as $e) {
            
            # 查看屬性 echo $e->description ;
            //echo $e->elementName . " | " ;
            $cmd->bindValue(":elementName", $e->elementName);

            $cmd->bindValue(":startTime", "");
            $cmd->bindValue(":endTime", "");
            $cmd->bindValue(":dataTime", "");

            foreach ($e->time as $t) {
                
                if (isset($t->startTime)){
                    //echo $t->startTime . " - " ;
                    $cmd->bindValue(":startTime", $t->startTime);
                }
                if (isset($t->endTime)){
                    //echo $t->endTime . "<br>" ;
                    $cmd->bindValue(":endTime", $t->endTime);
                }
                if (isset($t->dataTime)){
                    //echo $t->dataTime . "<br>" ;
                    $cmd->bindValue(":dataTime", $t->dataTime);
                }

                $cmd->bindValue(":value", "");
                $cmd->bindValue(":measures", "");

                foreach ($t->elementValue as $v) {
                    
                    //echo $v->value . " " ;
                    $cmd->bindValue(":value", $v->value);

                    //echo $v->measures . "<br>" ;
                    $cmd->bindValue(":measures", $v->measures);
                    break ;
                }
                $dbIndex++ ;
                $cmd->bindValue(":dbIndex", $dbIndex) ; 
                $cmd->execute();
                //echo "<br>" ;
            }
            //echo "<hr>" ;
        }
        // break ; // 只測試一縣市就先停在這裏
    }     
}
$db = NULL ;

?>