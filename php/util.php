<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function dump ($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}