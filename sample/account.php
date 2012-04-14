<?php

use Robowhois\Robowhois;
use Robowhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

try {
    $account =  $robowhois->whoisAccount();

    echo $account->getCreditsRemaining();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}