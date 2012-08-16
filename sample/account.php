<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $account =  $robowhois->account();

    echo $account->getCreditsRemaining();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}