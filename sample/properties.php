<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $domain = $robowhois->whoisProperties('robowhois.com');
    
    echo $domain['properties']['created_on'] . "\n";
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}