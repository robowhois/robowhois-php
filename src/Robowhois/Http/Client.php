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
    * @param Browser $adapter  The HTTP adapter used to make HTTP requests
    */
    public function __construct()
    {
        $this->adapter = $this->getDefaultAdapter();
    }
    
    /**
    * @inheritedDoc
    */
    public function authenticate($apiKey)
    {
        $this->apiKey = $apiKey;
        
        curl_setopt(
            $this->getAdapter()->getClient()->getCurl(),
            CURLOPT_USERPWD,
            $this->getApiKey() . ":X"
        );
    }
  
    /**
    * @inheritedDoc
    */
    public function get($uri)
    {
        $browserResponse = $this->getAdapter()->get($uri);

        return new Response(
            $browserResponse->getContent(), 
            $browserResponse->getStatusCode(), 
            $browserResponse->getHeaders()
        );
    }
  
    /**
    * Configures the adapter for authentication against the Robowhois API. 
    */
    protected function getDefaultAdapter()
    {
        $adapter  = new Browser;
        $client   = new \Buzz\Client\Curl();
        $client->setTimeout(5);
        $adapter->setClient($client);
        
        return $adapter;
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
