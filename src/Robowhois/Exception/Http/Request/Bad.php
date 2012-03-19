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
 * Class Bad
 *
 * @package     Robowhois
 * @subpackage  Exception
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\Exception\Http\Request;

use Robowhois\Exception\Http\Response as ResponseException;

class Bad extends ResponseException
{
    const MESSAGE = "The client got a %d status code when retrieving the resource at %s: this may be caused by a temporary failure of the WHOIS origin service";
}

