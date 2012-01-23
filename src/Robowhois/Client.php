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
 * Class Client
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois;

use Buzz\Browser;

class Client
{
    protected $browser;
    protected $token;
    
    public function __construct(Browser $browser, $token)
    {
        $this->browser = $browser;
        $this->token = $token;
    }
    
    public function getAvailability(Domain $domain)
    {
        $this->getBrowser()->setClient(new \Buzz\Client\Curl);
        curl_setopt($this->getBrowser()->getClient()->getCurl(), CURLOPT_USERPWD, $this->token . ":X");
        $response = $this->getBrowser()->get("http://api.robowhois.com/whois/" . $domain . "/availability");
        $json = json_decode($response->getContent(), true);
        $domain->setAvailable($json['response']['available']);
    }
    
    protected function getBrowser()
    {
        return $this->browser;
    }
}

