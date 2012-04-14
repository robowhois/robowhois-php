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
 * Class Record
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\Whois;

use Robowhois\ArrayObject;

class Record extends ArrayObject
{
    protected $record;
    protected $daystamp;
    
    /**
     * Creates a new Record from its raw content and daystamp.
     * 
     * @param array $record
     */
    public function __construct(array $record)
    {
        $this->data = $record;
    }
    
    public function __toString()
    {
        return $this->getRecord();
    }
}