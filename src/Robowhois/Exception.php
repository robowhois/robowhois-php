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

namespace Robowhois;

class Exception extends \Exception
{
    public function __construct($message)
    {
        $this->message = $message;
    }
}

