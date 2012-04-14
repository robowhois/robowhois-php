<?php

/*
 * This file is part of the robowhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) David Funaro <ing.davidino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ArrayObject
 *
 * @package     
 * @subpackage  
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois;

use Doctrine\Common\Util\Inflector;

abstract class ArrayObject implements \ArrayAccess
{
    protected $data = array();
    
    /**
     * Magic method used to implement getters.
     * If $this->data contains 'arrayIndex' you'll be able to call
     * $this->getArrayIndex().
     *
     * @param   string $name
     * @param   array $arguments
     * @return  ArrayObject 
     */
    public function __call($name, $arguments)
    {
        $offset = Inflector::tableize(substr($name, 3));
        
        if (isset($this[$offset])) {
            return $this[$offset];
        }
        
        throw new Exception(sprintf(
            'Object %s has no %s property', 
            get_called_class(), 
            $offset
        ));
    }
    
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }
    
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }
    }
    
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }
    
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }
}

