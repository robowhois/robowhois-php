<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $whois = $robowhois->whoisRecord('robowhois.com');
    
    echo $whois['daystamp'] . "\n";
    echo $whois->getRecord();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}