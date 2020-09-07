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

    public function accumRainApi() {
        $json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-0387CE9B-6B9C-43AB-A6F7-E03CC452690C&elementName=RAIN,HOUR_24') ;
        $obj = json_decode($json) ;
        $obj = $obj->records->location;
        return $obj;
    }

    public function runUpdateOne($tableName,$data) {

        $sql = "TRUNCATE TABLE $tableName";
        $this->insert($sql);

        $sql = "INSERT INTO $tableName (`location`,`day`,`hour`,`wx`,`pop`,`mint`,`maxt`) VALUES";
        foreach ($data as $d) {
            $sql = $sql . " ('$d->location','$d->day','$d->hour','$d->wx','$d->pop','$d->mint','$d->maxt'),";
        }
        $sql = substr_replace($sql,"",-1);
        $this->insert($sql);
    }

    public function runUpdateTwo($tableName,$data) {

        $sql = "TRUNCATE TABLE $tableName";
        $this->insert($sql);

        $sql = "INSERT INTO $tableName (`location`,`day`,`hour`,`wx`,`t`,`pop6h`) VALUES";
        foreach ($data as $d) {
            $sql = $sql . " ('$d->location','$d->day','$d->hour','$d->wx','$d->t','$d->pop6h'),";
        }
        $sql = substr_replace($sql,"",-1);
        $this->insert($sql);
    }

    public function runUpdateWeek($tableName,$data) {

        $sql = "TRUNCATE TABLE $tableName";
        $this->insert($sql);

        $sql = "INSERT INTO $tableName (`location`,`day`,`hour`,`wx`,`mint`,`maxt`) VALUES";
        foreach ($data as $d) {
            $sql = $sql . " ('$d->location','$d->day','$d->hour','$d->wx','$d->mint','$d->maxt'),";
        }
        $sql = substr_replace($sql,"",-1);
        $this->insert($sql);
    }

    public function updateAccumRain($tableName,$data) {

        $sql = "TRUNCATE TABLE $tableName";
        $this->insert($sql);
        
        $sql = "INSERT INTO $tableName (`city`,`location`,`hour`,`day`) VALUES";
        foreach ($data as $d) {
            $sql = $sql . " ('$d->city','$d->location','$d->hour','$d->day'),";
        }
        $sql = substr_replace($sql,"",-1);
        $this->insert($sql);
    }

    public function getTodayWeather($cityName) {

        $sql = "SELECT * FROM `oneday` WHERE `location` = ? ";
        $param = array($cityName);
        $result = $this->select($sql,$param);

        return $result;
    }

    public function getTwoDayWeather($cityName,$hour) {
       
        $sql = "SELECT * FROM `twoday` WHERE (`location` = ?) AND (`hour` = ?)";
        $param = array($cityName,$hour);
        $result = $this->selectAll($sql,$param);

        return $result;
    }

    public function getWeekWeather($cityName,$hour) {
       
        $sql = "SELECT * FROM `week` WHERE (`location` = ?) AND (`hour` = ?)";
        $param = array($cityName,$hour);
        $result = $this->selectAll($sql,$param);

        return $result;
    }
}

?>