<?php

require_once('./includes/class-autoload.php');

// $update = new WeatherContr();
// $update->updateWeather();

$view = new WeatherView();


if(isset($_POST['submit'])) {
    $view->showWeather($_POST['city']);
}
$view->showWeather('臺中市');



?>