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
 * Class Domain
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois;

class Domain
{
    protected $identifier;
    protected $isAvailable;
  
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }
  
    public function __toString()
    {
        return $this->identifier;
    }
    
    public function isAvailable()
    {
        return $this->isAvailable;
    }
    
    public function setAvailable($isAvailable = true)
    {
        $this->isAvailable = $isAvailable;
    }
}

