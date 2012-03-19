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
use Robowhois\Whois\Account;
use Robowhois\Whois\Record;
use Robowhois\Http\Client as HttpClient;
use Buzz\Browser;
use Robowhois\Exception;
use Robowhois\Exception\Http as HttpException;
use Robowhois\Exception\Http\Request\Unauthorized as UnauthorizedRequest;
use Robowhois\Exception\Http\Request\Bad as BadRequest;
use Robowhois\Exception\Http\Response\NotFound as ResourceNotFound;
use Robowhois\Exception\Http\Response\BadGateway as BadGatewayException;
use Robowhois\Exception\Http\Response\ServerError as InternalServerError;
use Robowhois\Exception\Http\Response as ResponseException;
use Robowhois\Exception\Http\Response\VoidResponse;

class Robowhois
{
    private $apiKey;
    private $client;

    const API_ENTRY_POINT            = "http://api.robowhois.com";
    const API_INDEX_ENDPOINT         = "/whois/:domain";
    const API_AVAILABILITY_ENDPOINT  = "/whois/:domain/availability";
    const API_ACCOUNT_ENDPOINT       = "/account";
    const API_RECORD_ENDPOINT        = "/whois/:domain/record";
    
    
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
     * Retrieves the information about account
     * 
     * @return Robowhois\Whois\Account
     */
    public function whoisAccount()
    {
        $response   = $this->callApi(null, 'ACCOUNT');

        $values = json_decode($response->getContent(), true);
        $value  = array_key_exists('account', $values) ? $values['account'] : null;

        if (!count($value))  
            throw new Exception();

        $id                = array_key_exists('id', $value)                ? $value['id']                : null;
        $email             = array_key_exists('email', $value)             ? $value['email']             : null;
        $api_token         = array_key_exists('api_token', $value)         ? $value['api_token']         : null;
        $credits_remaining = array_key_exists('credits_remaining', $value) ? $value['credits_remaining'] : null;
        
        return new Account($id, $email, $api_token, $credits_remaining);
    }

    /**
     * Convenient method to check if the given $domain is available.
     * 
     * @param   string $domain
     * @return  boolean
     */
    public function isAvailable($domain)
    {
        $availability = $this->whoisAvailability($domain);
      
        return $availability['available'];
    }

    /**
     * Convenient method to check if the given $domain is registered.
     * 
     * @param   string $domain
     * @return  boolean
     */
    public function isRegistered($domain)
    {      
        return !$this->isAvailable($domain);
    }
    
    /**
     * Retrieves an array containing availability information for the given
     * $domain.
     * 
     * @param string $domain
     * 
     * @return Array
     * @todo meaningful exception message
     */
    public function whoisAvailability($domain)
    {      
        $response     = $this->callApi($domain, 'AVAILABILITY');
        $resultArray  = json_decode($response->getContent(), true);
        
        if (!is_array($resultArray) || !isset($resultArray['response'])) {
          throw new Exception();
        }
        
        return $resultArray['response'];
    }
    
    /**
     * Retrieves the raw information about a whois record.
     * 
     * @param string $domain
     * 
     * @return Robowhois\Whois\Index
     * @todo meaningful exception message
     */
    public function whoisIndex($domain)
    {        
        return new Index($this->callApi($domain, 'INDEX')->getContent());
    }
    
    /**
     * Retrieves the raw information about a whois record.
     * 
     * @param string $domain
     * 
     * @return Robowhois\Whois\Index
     */
    public function whoisrecord($domain)
    {        
        $response = json_decode($this->callApi($domain, 'RECORD')->getContent(), true);
        
        if (is_array($response) && isset($response['response'])) {
          $result = $response['response'];
          
          if (is_array($result) && isset($result['record']) && isset($result['daystamp'])) {
            return new Record($result['record'], $result['daystamp']);
          }
        }
      
        throw new Exception;
    }
    
    /**
     * Calls the given $api for the given $domain (eg 'INDEX' => 'google.com').
     *
     * @param   string $domain
     * @param   string $api
     * @return  Symfony\Component\HttpFoundation\Response
     */
    protected function callApi($domain, $api)
    {
        $this->getClient()->authenticate($this->getApiKey());
        $constant = sprintf('API_%s_ENDPOINT', $api);
        $refClass = new \ReflectionClass(__CLASS__);
        $endpoint = $refClass->getConstant($constant);
        $uri      = self::API_ENTRY_POINT . str_replace(":domain", $domain, $endpoint);
        
        return $this->retrieveResponse($uri);
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
     * @throws  Robowhois\Exception\Http\Response\VoidResponse
     * @throws  Robowhois\Exception\Http
     * @throws  Robowhois\Exception\Http\Request\Unauthorized
     * @throws  Robowhois\Exception\Http\Request\Bad
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
                if ($response->getContent())
                    return $response;
                
                throw new VoidResponse($response,$uri);
            case 400:
                throw new BadRequest($response, $uri);
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

