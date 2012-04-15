<?php

use Robowhois\Robowhois;
use Robowhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

try {
    $domains = array(
      'google.com', 'mycustomabsurddomainnamenooneeverregistered.ch'
    );

    foreach ($domains as $domain) {
        $availability = $robowhois->whoisAvailability($domain);

        if ($availability['available']) {
            echo sprintf("%s is available!", $domain) . "\n";
        } else {
            echo sprintf("%s is registered!", $domain) . "\n";
        } 
    }
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}