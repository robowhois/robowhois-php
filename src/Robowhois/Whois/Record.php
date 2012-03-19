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

class Record
{
    protected $record;
    protected $daystamp;
    
    /**
     * Creates a new Record from its raw content and daystamp.
     * 
     * @param string $record
     * @param string $daystamp
     */
    public function __construct($record, $daystamp)
    {
        $this->record   = $record;
        $this->daystamp = $daystamp;
    }
    
    public function __toString()
    {
        return $this->getRecord();
    }
    
    /**
     * Returns the daystamp associated with this record.
     *
     * @return string
     * @todo datetime
     */
    public function getDaystamp()
    {
      return $this->daystamp;
    }
    
    /**
     * Returns the raw record informations.
     * 
     * @return string
     */
    public function getRecord()
    {
        return $this->record;
    }
}