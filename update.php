<?php

require_once('./includes/class-autoload.php');

$update = new WeatherContr();
//$update->updateWeather();

# run script in server background
ignore_user_abort(TRUE);

# run script forever
set_time_limit(0);

# do every second * time
$interval = 60 * 30; //60*30 = 30minutes

do {

    $update->updateWeather();

    sleep($interval);

}while (TRUE);

?>