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
 * Class RoboWhois
 *
 * @package     RoboWhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace RoboWhois;

use RoboWhois\Contract\Http\Client;
use RoboWhois\Account;
use RoboWhois\Whois\Availability;
use RoboWhois\Whois\Record;
use RoboWhois\Whois\Parts;
use RoboWhois\Whois\Properties;
use RoboWhois\Http\Client as HttpClient;
use Buzz\Browser;
use Symfony\Component\HttpFoundation\Response;
use RoboWhois\Exception;
use RoboWhois\Exception\Http\Response\VoidResponse;

class RoboWhois
{
    private $apiKey;
    private $client;

    const API_ENTRY_POINT            = "http://api.robowhois.com";
    const API_INDEX_ENDPOINT         = "/whois/:domain";
    const API_PROPERTIES_ENDPOINT    = "/whois/:domain/properties";
    const API_PARTS_ENDPOINT         = "/whois/:domain/parts";
    const API_AVAILABILITY_ENDPOINT  = "/whois/:domain/availability";
    const API_ACCOUNT_ENDPOINT       = "/account";
    const API_RECORD_ENDPOINT        = "/whois/:domain/record";
    const API_RESPONSE_ERROR         = "There was an error while processing your request: RoboWhois API sent a malformed response";
    
    
    /**
     * Instantiates a new RoboWhois object with the given $apiKey
     * and an internal http $client.
     * 
     * @param string                         $apiKey
     * @param RoboWhois\Contract\Http\Client $client
     */
    public function __construct($apiKey, Client $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?: new HttpClient();
    }
    
    /**
     * Retrieves the information about account
     * 
     * @return RoboWhois\Whois\Account
     */
    public function account()
    {
        $response         = $this->callApi(null, 'ACCOUNT');
        $values           = json_decode($response->getContent(), true);
        
        if (!is_array($values)) {
            throw new Exception(self::API_RESPONSE_ERROR);
        }
        
        $values           = isset($values['account']) ? $values['account'] : null;
        
        return new Account($values);
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
     */
    public function whoisAvailability($domain)
    {      
        $response     = $this->callApi($domain, 'AVAILABILITY');
        $resultArray  = json_decode($response->getContent(), true);
        
        if (!is_array($resultArray) || !isset($resultArray['response'])) {
          throw new Exception(self::API_RESPONSE_ERROR);
        }
        
        return new Availability($resultArray['response']);
    }
    
    /**
     * Retrieves the raw information about a whois record.
     * 
     * @param string $domain
     * 
     * @return RoboWhois\Whois\Index
     */
    public function whois($domain)
    {        
        $content = $this->callApi($domain, 'INDEX')->getContent();
        
        return $content;
    }
    
    /**
     * Returns the parts of the given $domain.
     *
     * @param   string $domain
     * @return  RoboWhois\Whois\Parts
     */
    public function whoisParts($domain)
    {
        $response = $this->decodeApiCall($domain, 'PARTS');
        
        if (is_array($response) && isset($response['response'])) {
            return new Parts($response['response']);
        }
      
        throw new Exception(self::API_RESPONSE_ERROR);
    }
    
    /**
     * Returns the properties of the given $domain.
     *
     * @param   string $domain
     * @return  RoboWhois\Index\Properties 
     */
    public function whoisProperties($domain)
    {
        $response = $this->decodeApiCall($domain, 'PROPERTIES');
        
        if (is_array($response) && isset($response['response'])) {
            return new Properties($response['response']);
        }
      
        throw new Exception(self::API_RESPONSE_ERROR);
    }
    
    /**
     * Retrieves the raw information about a whois record.
     * 
     * @param string $domain
     * 
     * @return RoboWhois\Whois\Index
     */
    public function whoisRecord($domain)
    {        
        $response = $this->decodeApiCall($domain, 'RECORD');
        
        if (is_array($response) && isset($response['response'])) {
            return new Record($response['response']);
        }
      
        throw new Exception(self::API_RESPONSE_ERROR);
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
     * Checks whether the given $content is empty: if so, throws an exception
     * since the API server did not provide informations for the sent request.
     *
     * @param   string $content
     * @param   string $uri 
     * @return  null
     * @throws  RoboWhois\Exception
     */
    protected function checkResponseContent($content = null, $uri) {
        if (empty($content)) {
            $message = sprintf("Empty response from resource %s", $uri);

            throw new Exception($message);
        }
    }
    
    /**
     * JSON-decodes the content of the $type API response for the given $domain.
     *
     * @param   string $domain
     * @param   string $type
     * @return  array
     */
    protected function decodeApiCall($domain, $type)
    {
        return json_decode($this->callApi($domain, $type)->getContent(), true);
    }
    
    /**
     * Returns the API key associated with this RoboWhois instance.
     *
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Returns the client associated associated with thisRoboWhois instance.
     *
     * @return RoboWhois\Contract\Http\Client 
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
     * @throws  RoboWhois\Exception\Http\Response
     */
    protected function retrieveResponse($uri)
    {
        $response = $this->getClient()->get($uri);
      
        switch ($response->getStatusCode()) {
            case 200:
                $this->checkResponseContent($response->getContent(), $uri);
                    
                return $response;
            default:
                $this->throwApiError($response);
        }
    }
    
    /**
     * Throws a generic API error due to an invalid HTTP response.
     *
     * @param   Response $response 
     * @throws  RoboWhois\Exception
     */
    protected function throwApiError(Response $response)
    {                
        $message = sprintf(
                "Status code %d\r\n%s",
                $response->getStatusCode(),
                $response->getContent()
        );

        throw new Exception($message, $response);
    }
}

