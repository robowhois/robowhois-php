<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $domain = $robowhois->whoisParts('robowhois.com');

    echo $domain['parts'][0]['body'] . "\n";
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}