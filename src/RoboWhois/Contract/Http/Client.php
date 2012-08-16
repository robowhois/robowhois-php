<?php

/*
 * This file is part of the RoboWhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class Client
 *
 * @package     RoboWhois
 * @subpackage  Http
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 */

namespace RoboWhois\Contract\Http;

interface Client
{
    /**
    * Sets the authentication key for performing API requests for the HTTP
    * client.
    */
    public function authenticate($apiKey);
    
    /**
    * Executes a GET request on the specified $uri and returns an HTTP response.
    * 
    * @return \Symfony\Component\HttpFoundation\Response;
    */
    public function get($uri);
}

