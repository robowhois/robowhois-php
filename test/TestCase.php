<?php

/*
 * This file is part of the RoboWhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) David Funaro <ing.davidino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class RoboWhoisTest
 *
 * @package     RoboWhois
 * @subpackage  Test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace test;

use RoboWhois\RoboWhois;
use RoboWhois\Http\Client;
use Stub\Http\Client as StubClient;
use Buzz\Browser;

class TestCase extends \PHPUnit_Framework_TestCase
{  
    protected function getApiKey()
    {
        $apiKey =  file_get_contents(__DIR__ . "/.token");

        return $apiKey;
    }
    
    protected function getWebService()
    {
        return new RoboWhois($this->getApiKey());
    }
}

