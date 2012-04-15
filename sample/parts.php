<?php

use Robowhois\Robowhois;
use Robowhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

try {
    $domain = $robowhois->whoisParts('robowhois.com');

    echo $domain['parts'][0]['body'] . "\n";
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}