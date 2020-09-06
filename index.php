<?php

require_once('./includes/class-autoload.php');

$weather = new WeatherContr();

$update = $weather->updateWeather();

?>