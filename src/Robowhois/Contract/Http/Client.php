<?php

/*
 * This file is part of the Robowhois package.
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
 * @package     
 * @subpackage  
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 */

namespace Robowhois\Contract\Http;

interface Client
{
  /**
   * Executes a GET request on the specified $uri and returns an HTTP response.
   * 
   * @return \Symfony\Component\HttpFoundation\Response;
   */
  public function get($uri);
}

