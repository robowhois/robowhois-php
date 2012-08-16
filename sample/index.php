<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    echo $robowhois->whois('robowhois.com');
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}