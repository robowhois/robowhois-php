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

namespace Robowhois\Exception;

use Robowhois\Exception;
use Symfony\Component\HttpFoundation\Response;

class Http extends Exception
{
  const MESSAGE = "Invalid HTTP response.\nStatus code is %d, here's the body: \n%s";
  
    /**
     * Builds a generic HTTP exception with the status code and the body of an
     * HTTP response.
     *
     * @param Symfony\Component\HttpFoundation\Response $response 
     */
    public function __construct(Response $response)
    {
        $this->message = sprintf(
            self::MESSAGE, 
            $response->getStatusCode(), 
            $response->getContent()
        );
    }
}

