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

namespace Robowhois\Exception\Http;

use Robowhois\Exception;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response extends Exception
{
    const MESSAGE = "The client got a %d status code when retrieving the resource at %s";
    
    /**
     * Builds a generic exception for a $response generated at the given $uri.
     *
     * @param Symfony\Component\HttpFoundation\Response $response
     * @param string $uri 
     */
    public function __construct(HttpResponse $response, $uri)
    {
      $this->message = sprintf(self::MESSAGE, $response->getStatusCode(), $uri);
    }
}

