<?php

class WeatherContr extends Weather {

public function updateWeather() {
    
    // $time_start = microtime(true);

    $data = $this->constructOneDay();
    $this->runUpdateOne('oneday', $data);

    $data = $this->constructTwoDay();
    $this->runUpdateTwo('twoday', $data);

    $data = $this->constructWeek();
    $this->runUpdateWeek('week', $data);

    $data = $this->constructAccumRain();
    $this->updateAccumRain('accumlaterain', $data);

    // $time_end = microtime(true);
    // echo $time_end - $time_start;
}

public function constructAccumRain() {
    $api = $this->accumRainApi();
    $data = [];

    foreach ($api as $loc) {
        
        $hour = ($loc->weatherElement[0]->elementValue <= 0) ? '-' : $loc->weatherElement[0]->elementValue;
        $day = ($loc->weatherElement[1]->elementValue <= 0) ? '-' : $loc->weatherElement[1]->elementValue;

        $row = (object)["city"     => $loc->parameter[0]->parameterValue,
                        "location" => $loc->locationName,
                        "hour"     => $hour,
                        "day"      => $day ];
        $data[] = $row;
    } 
    return($data);
}

public function constructOneDay() {
    $api = $this->oneDayApi();
    $data = [] ;

    foreach ($api as $l){

        $row = (object)["location" => $l->locationName];

        foreach ($l->weatherElement as $e) {
            
            foreach ($e->time as $t) {
                #data filter will do here below

                $getTime = $t->startTime;
                $getDay = substr($getTime,0,10);
                $getHour = substr($getTime,11,2);
                
                # if time is not 0600 or 1800 we don't need it , pass again
                if (!($getHour == 18 || $getHour == 6)){
                    continue;
                }
                
                $row->day  = $getDay;
                $row->hour = $getHour;          

                # if code above can run until here ,do next step
                foreach ($t->parameter as $key => $item) {

                    if (!is_numeric($item))
                        continue ;
                    
                    if ($e->elementName == "Wx")
                        $row->wx = $item;
                    else if ($e->elementName == "PoP")
                        $row->pop = $item;
                    else if ($e->elementName == "MinT")
                        $row->mint = $item;
                    else if ($e->elementName == "MaxT")
                        $row->maxt = $item;
                }
                
                # we just want 1 city 1 row data of today
                # if want more row erase 'break'
                break;
            }
        }
        $data[] = $row;
    }
    # end of foreach
    return($data);
}
# END OF FUNCTION

public function constructTwoDay() {

    $api = $this->twoDayApi();
    $data = [] ;
    
    foreach ($api as $l){
        foreach ($l->weatherElement as $e) {
            foreach ($e->time as $t) {
                #data filter will do here below

                $getTime = (isset($t->startTime)) ? $t->startTime : $t->dataTime;
                $getDay = substr($getTime,0,10);
                $getHour = substr($getTime,11,2);
                
                $today = date("Y-m-d") ;
                
                # if getDay biggest than today, that means getDay not today
                if ($getDay > $today ) {
                    
                    $now = new DateTime($today);
                    $later = new DateTime($getDay);
                    $diff = $later->diff($now)->format("%a");

                    # we just want 2days data, more than 2days we skip
                    if ($diff > 2)
                        continue;
                } else {
                    # if day is today, we dont need these data, so skip this loop
                    continue;
                }

                # if time is not 0600 or 1800 we don't need it , pass again
                if (!($getHour == 18 || $getHour == 6)){
                    continue;
                }

                foreach ($l->weatherElement as $ee) {

                }

                # if code above can run until here ,do next step
                foreach ($t->elementValue as $v) {
                
                    if (!is_numeric($v->value))
                        continue ;
                    
                    $row = (object) ["location" => $l->locationName,
                                        "element"  => $e->elementName,
                                        "day"      => $getDay,
                                        "hour"     => $getHour,
                                        "value"    => $v->value];
                    $data[] = $row;
                }
            }
        }
    }
    # end of foreach

    # Sort out data format, make it clear
    $cityFlag = NULL;
    foreach ($data as $d) {

        if($cityFlag == $d->location) 
            if ($dayFlag >= $d->day && $hourFlag >= $d->hour){
                continue; 
        }
        
        $row = (object)["location" => $d->location];

        $row->day  = $d->day;
        $row->hour = $d->hour;  

        foreach ($data as $s) {

            # Set flag
            $dayFlag = $d->day;
            $hourFlag = $d->hour;
            $cityFlag = $d->location;

            if ($s->location != $d->location)
                continue;
            
            if ($d->day != $s->day || $d->hour != $s->hour)
                continue;

            if ($s->element == "Wx")
                $row->wx = $s->value;
            else if ($s->element == "PoP6h")
                $row->pop6h = $s->value;
            else if ($s->element == "T")
                $row->t = $s->value;
        }
        $result[] = $row;
    }
    # end of foreach
    return($result);
}
# END OF FUNCTION

public function constructWeek() {

    $api = $this->weekApi();
    $data = [] ;

    foreach ($api as $l){
        foreach ($l->weatherElement as $e) {
            foreach ($e->time as $t) {
                #data filter will do here below

                $getTime = (isset($t->startTime)) ? $t->startTime : $t->dataTime;
                $getDay = substr($getTime,0,10);
                $getHour = substr($getTime,11,2);
                
                $today = date("Y-m-d") ;
                
                # if getDay biggest than today, that means getDay not today
                if ($getDay > $today ) {
                    
                    $now = new DateTime($today);
                    $later = new DateTime($getDay);
                    $diff = $later->diff($now)->format("%a");

                    # we just want 7days data, more than 7days we skip
                    if ($diff > 7)
                        continue;
                } 
                // else {
                //     # if day is today, we dont need these data, so skip this loop
                //     continue;
                // }

                # if time is not 0600 or 1800 we don't need it , pass again
                if (!($getHour == 18 || $getHour == 6)){
                    continue;
                }
                
                # if code above can run until here ,do next step
                foreach ($t->elementValue as $v) {

                    if (!is_numeric($v->value))
                        continue ;
                    
                    $row = (object) ["location" => $l->locationName,
                                     "element"  => $e->elementName,
                                     "day"      => $getDay,
                                     "hour"     => $getHour,
                                     "value"    => $v->value];
                    $data[] = $row;
                }
            }
        }
    }
    # end of foreach

    # Sort out data format, make it clear
    $cityFlag = NULL;
    foreach ($data as $d) {

        if($cityFlag == $d->location) 
            if ($dayFlag >= $d->day && $hourFlag >= $d->hour){
                continue; 
        }
        
        $row = (object)["location" => $d->location];

        $row->day  = $d->day;
        $row->hour = $d->hour;  

        foreach ($data as $s) {

            # Set flag
            $dayFlag = $d->day;
            $hourFlag = $d->hour;
            $cityFlag = $d->location;

            if ($s->location != $d->location)
                continue;
            
            if ($d->day != $s->day || $d->hour != $s->hour)
                continue;

            if ($s->element == "Wx")
                $row->wx = $s->value;
            else if ($s->element == "MinT")
                $row->mint = $s->value;
            else if ($s->element == "MaxT")
                $row->maxt = $s->value;
        }
        $result[] = $row;
    }
    # end of foreach
    return($result);
}
# END OF FUNCTION

}
# END OF CLASS
?>