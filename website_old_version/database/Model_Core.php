<?php

// Load DB  library
require_once 'meekrodb.2.3.class.php';

// Load DB configuration
require_once 'db_config.php';


function dutch_strtotime($datetime) {
    $months = array(
        "januari"   => "January",
        "februari"  => "February",
        "maart"     => "March",
        "april"     => "April",
        "mei"       => "May",
        "juni"      => "June",
        "juli"      => "July",
        "augustus"  => "August",
        "september" => "September",
        "oktober"   => "October",
        "november"  => "November",
        "december"  => "December"
    );

    $array = explode(" ", $datetime);
    $array[1] = $months[strtolower($array[1])];
    return strtotime(implode(" ", $array));
}

