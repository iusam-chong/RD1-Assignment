<?php
function update($command,$obj){

@$db = setupDb() ;
$cmd = $db->prepare($command) ;
$dbIndex = 0 ;

foreach ($obj->records->locations as $ls ) {
    
    foreach ($ls->location as $l){
        
        $cmd->bindValue(":locationName", $l->locationName);

        foreach ($l->weatherElement as $e) {
            
            # 查看屬性 echo $e->description ;
            $cmd->bindValue(":elementName", $e->elementName);

            $cmd->bindValue(":startTime", "");
            $cmd->bindValue(":endTime", "");
            $cmd->bindValue(":dataTime", "");

            foreach ($e->time as $t) {
                
                if (isset($t->startTime)){
                    $cmd->bindValue(":startTime", $t->startTime);
                }
                if (isset($t->endTime)){
                    $cmd->bindValue(":endTime", $t->endTime);
                }
                if (isset($t->dataTime)){
                    $cmd->bindValue(":dataTime", $t->dataTime);
                }

                $cmd->bindValue(":value", "");
                $cmd->bindValue(":measures", "");

                foreach ($t->elementValue as $v) {
                    
                    $cmd->bindValue(":value", $v->value);

                    $cmd->bindValue(":measures", $v->measures);
                    break ;
                }
                $dbIndex++ ;
                $cmd->bindValue(":dbIndex", $dbIndex) ; 
                $cmd->execute();
            }
        }
    }     
}
$db = NULL ;

}
?>