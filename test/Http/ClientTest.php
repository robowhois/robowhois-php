<?php

/*
 * This file is part of the Orient package.
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
 * @package     
 * @subpackage  
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

use Robowhois\Http\Client;

class Response
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

class Browser extends Buzz\Browser
{
  public function get($url, $headers = array())
  {
    return new Response();
  }
}

class ClientTest extends \PHPUnit_Framework_TestCase
{
  public function testTheClientReturnsAResponse()
  {
    $client = new Client(new Browser());
    
    $this->assertInstanceOf("\Symfony\Component\HttpFoundation\Response", $client->get('http://www.google.com'));
  }
}

