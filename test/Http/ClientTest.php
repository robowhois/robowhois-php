<?php

/*
 * This file is part of the Robowhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) David Funaro <ing.davidino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ClientTest
 *
 * @package     Robowhois
 * @subpackage  Test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace test;

use Robowhois\Http\Client;

class StubResponse
{  
    public function getContent()
    {
        return "";
    }

    public function getStatusCode()
    {
        return 200;
    }

    public function getHeaders()
    {
        return array();
    }
}

class StubBrowser extends \Buzz\Browser
{
    public function get($url, $headers = array())
    {
        return new StubResponse();
    }
}

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
      $this->client = new Client();
    }
  
    public function testTheClientReturnsAResponse()
    {
        $this->assertInstanceOf(
                "\Symfony\Component\HttpFoundation\Response",
                $this->client->get('http://www.google.com')
        );
    }
}

