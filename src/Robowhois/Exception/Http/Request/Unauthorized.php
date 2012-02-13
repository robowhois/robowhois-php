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
 * Class Http
 *
 * @package     Robowhois
 * @subpackage  Exception
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\Exception\Http\Request;

use Robowhois\Exception\Http\Response as ResponseException;

class Unauthorized extends ResponseException
{
    const MESSAGE = "The request made with the API key \"%s\" has been rejected: is the key valid?";
    
    /**
     * Builds a new exception telling that the api key used for the HTTP
     * requests is invalid.
     *
     * @param string $apiKey 
     */
    public function __construct($apiKey)
    {
      $this->message = sprintf(self::MESSAGE, $apiKey);
    }
}

