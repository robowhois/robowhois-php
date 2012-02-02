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
    protected $apiKey;

    /**
    * Creates a new instance of an HTTP client customized for Robowhois APIs.
    *
    * @param string  $apiKey   The api key of Robowhois
    * @param Browser $adapter  The HTTP adapter used to make HTTP requests
    */
    public function __construct($apiKey, Browser $adapter)
    {
        $this->adapter  = $adapter;
        $this->apiKey   = $apiKey;
        $this->configureAdapter();
    }
  
    /**
    * @inheritedDoc
    */
    public function get($uri)
    {
        $response = $this->getAdapter()->get($uri);

        return new Response(
            $response->getContent(), 
            $response->getStatusCode(), 
            $response->getHeaders()
        );
    }
  
    /**
    * Configures the adapter for authentication against the Robowhois API. 
    */
    protected function configureAdapter()
    {
        $this->getAdapter()->setClient(new \Buzz\Client\Curl);
        curl_setopt(
            $this->getAdapter()->getClient()->getCurl(),
            CURLOPT_USERPWD,
            $this->getApiKey() . ":X"
        );
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

    /**
    * Returns the API key for this session.
    * 
    * @return string
    */
    protected function getApiKey()
    {
        return $this->apiKey;
    }
}
