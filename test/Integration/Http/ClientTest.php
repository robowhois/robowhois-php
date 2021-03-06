<?php

/*
 * This file is part of the RoboWhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ClientTest
 *
 * @package     RoboWhois
 * @subpackage  Test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace test\Integration;

use RoboWhois\Http\Client;
use Buzz\Browser;
use test\TestCase;

class ClientTest extends TestCase
{
    public function testRetrievingANonAuthenticatedResponse()
    {
      $client   = new Client();
      $response = $client->get("http://api.robowhois.com/account");

      $this->assertInstanceOf("\Symfony\Component\HttpFoundation\Response", $response);
      $this->assertEquals(401, $response->getStatusCode());
    }

    public function testRetrievingAnAuthenticatedResponseForTheAccountAPI()
    {
      $client   = new Client();

      $client->authenticate($this->getApiKey());
      $response = $client->get("http://api.robowhois.com/account");

      $this->assertInstanceOf("\Symfony\Component\HttpFoundation\Response", $response);
      $this->assertEquals(200, $response->getStatusCode());
    }
}

