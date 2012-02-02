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
 * Class Index
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\Whois;

class Index
{
    protected $content;
    
    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}