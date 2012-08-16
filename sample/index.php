<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    echo $robowhois->whois('robowhois.com')->getContent();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}