<?php

class Weather extends Dbh {

    // $sql = "INSERT INTO `accounts` (`customer_id`) VALUES (?)";
    // $param = array($customerId);
    // $this->insert($sql, $param);

    public function oneDayApi() {
        $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=Wx,PoP,MinT,MaxT') ;
        $obj = json_decode($json) ;
        $obj = $obj->records->location;
        return $obj;
    }

    public function twoDayApi() {
        $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=Wx,T,PoP6h&sort=time') ;
        $obj = json_decode($json) ;
        $obj = $obj->records->locations['0']->location;
        return $obj;
    }

    public function weekApi() {
        $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=MinT,MaxT,Wx') ;
        $obj = json_decode($json) ;
        $obj = $obj->records->locations['0']->location;
        return $obj;
    }

    public function runUpdate($tableName,$data) {

        $sql = "TRUNCATE TABLE $tableName";
        $this->insert($sql);

        $sql = "INSERT INTO $tableName (`location`,`element`,`day`,`hour`,`value`) VALUES";
        foreach ($data as $d) {
            $sql = $sql . " ('$d->location','$d->element','$d->day','$d->hour','$d->value'),";
        }
        $sql = substr_replace($sql,"",-1);
        $this->insert($sql);
    }

}

?>