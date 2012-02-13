<?php

/*
 * This file is part of the Robowhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class Robowhois
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois;

use Robowhois\Contract\Http\Client;
use Robowhois\Whois\Index;
use Robowhois\Http\Client as HttpClient;
use Buzz\Browser;
use Robowhois\Exception\Http as HttpException;
use Robowhois\Exception\Http\Request\Unauthorized as UnauthorizedRequest;
use Robowhois\Exception\Http\Response\NotFound as ResourceNotFound;
use Robowhois\Exception\Http\Response\BadGateway as BadGatewayException;
use Robowhois\Exception\Http\Response\ServerError as InternalServerError;
use Robowhois\Exception\Http\Response as ResponseException;

class Robowhois
{
    private $apiKey;
    private $client;
    
    const API_ENTRY_POINT       = "http://api.robowhois.com";
    const API_INDEX_ENDPOINT    = "/whois/:domain";
    
    /**
     * Instantiates a new Robowhois object with the given $apiKey
     * and an internal http $client.
     * 
     * @param string                         $apiKey
     * @param Robowhois\Contract\Http\Client $client
     */
    public function __construct($apiKey, Client $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?: new HttpClient();
    }
    
    /**
     * Retrieves the raw information about a whois record.
     * 
     * @param string $domain
     * 
     * @return Robowhois\Whois\Index
     */
    public function whoisIndex($domain)
    {
        $this->getClient()->authenticate($this->getApiKey());
        $uri        = self::API_ENTRY_POINT . str_replace(":domain", $domain, self::API_INDEX_ENDPOINT);
        $response   = $this->retrieveResponse($uri);
        
        return new Index($response->getContent());
    }
    
    /**
     * Returns the API key associated with this Robowhois instance.
     *
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Returns the client associated associated with thisRobowhois instance.
     *
     * @return Robowhois\Contract\Http\Client 
     */
    protected function getClient()
    {
        return $this->client;
    }
    
    /**
     * Executes an HTTP request at the given $uri and returns an HTTP response.
     *
     * @param   string $uri
     * @return  Symfony\Component\HttpFoundation\Response
     * @throws  Robowhois\Exception\Http
     * @throws  Robowhois\Exception\Http\Request\Unauthorized
     * @throws  Robowhois\Exception\Http\Response\NotFound
     * @throws  Robowhois\Exception\Http\Response\BadGateway
     * @throws  Robowhois\Exception\Http\Response\ServerError
     * @throws  Robowhois\Exception\Http\Response
     */
    protected function retrieveResponse($uri)
    {
        $response = $this->getClient()->get($uri);
      
        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            case 401:
                throw new UnauthorizedRequest($this->getApiKey());
            case 404:
                throw new ResourceNotFound($response, $uri);
            case 422:
                throw new ResponseException($response, $uri);
            case 502:
                throw new BadGatewayException($response, $uri);
            case 500:
                throw new InternalServerError($response, $uri);
            default:
                throw new HttpException($response);
        }
    }
}

