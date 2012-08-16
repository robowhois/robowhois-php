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
 * Class Http
 *
 * @package     RoboWhois
 * @subpackage  Exception
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace RoboWhois;

use Symfony\Component\HttpFoundation\Response;

class Exception extends \Exception
{
    protected $response;
    
    public function __construct($message, $response = null)
    {
        $this->message   = $message;
        $this->response  = $response;
    }
    
    /**
     * If an exception has been raise because of a bad request has been sent to
     * the RoboWhois API you can access the API response from here.
     *
     * @return Symfony\Component\HttpFoundation\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}

