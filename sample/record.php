<?php

use Robowhois\Robowhois;
use Robowhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

try {
    $whois = $robowhois->whoisRecord('robowhois.com');
    
    echo $whois->getDaystamp()->format('Y-m-d') . "\n";
    echo $whois->getRecord();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}