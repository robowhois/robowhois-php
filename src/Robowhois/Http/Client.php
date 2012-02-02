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
 * Class Client
 *
 * @package     Robowhois
 * @subpackage  Http
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\Http;

use Robowhois\Contract\Http\Client as HttpClient;
use Buzz\Browser;
use Symfony\Component\HttpFoundation\Response;

class Client implements HttpClient
{
  protected $adapter;
  
  /**
   * Creates a new instance of an HTTP client customized for Robowhois APIs.
   *
   * @param Browser $adapter The HTTP adapter used to make HTTP requests
   */
  public function __construct(Browser $adapter)
  {
      $this->adapter = $adapter;
  }
  
  /**
   * @inheritedDoc
   */
  public function get($uri)
  {
      $response     = $this->getAdapter()->get($uri);
      $httpResponse = new Response(
              $response->getContent(), 
              $response->getStatusCode(), 
              $response->getHeaders()
      );
      
      return $httpResponse;
  }
  
  /**
   * Returns the adapter used to tunnel HTTP requests.
   *
   * @return \Buzz\Browser
   */
  protected function getAdapter()
  {
      return $this->adapter;
  }
}

