<?php

use Robowhois\Robowhois;
use Robowhois\Exception;

require 'vendor/.composer/autoload.php';

$robowhois = new Robowhois('custom-robowhois-phpclient');

try
{
    echo $robowhois->whoisIndex('robowhois.com')->getContent();
}
catch (Exception $e)
{
    echo "The following error occurred: " . $e->getMessage();
}