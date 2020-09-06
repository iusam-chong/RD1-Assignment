<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
    $path = "classes/";
    $extension = ".php";
    $fileName = $path . $className . $extension;

    require_once $fileName ;
}


?>