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
     * Creates a new raw WHOIS record.
     * 
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
    
    public function __toString()
    {
        return $this->getContent();
    }
    
    /**
     * Returns the raw WHOIS informations for this object.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}