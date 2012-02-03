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
    public function __construct($apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
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
        $response   = $this->getClient()->get($uri);
        
        return new Index($response->getContent());
    }
    
    protected function getApiKey()
    {
        return $this->apiKey;
    }
    
    protected function getClient()
    {
        return $this->client;
    }
}

