<?php

namespace Pv;

class PArray extends Variable implements \ArrayAccess, \Iterator, \Countable
{
    /**
     * Current array index
     * @var integer
     */
    private $index = 0;

    /**
     * Initialize the object - check to ensure it's an array value
     * 
     * @param array $value Value to assign
     * @param array $type  Validation for the object
     */
    public function __construct($value,$type=null)
    {
        if (!is_array($value)) {
            throw new ValidationException('Variable type mismatch, expected array');
        }
        parent::__construct($value,$type);
    }

    /**
     * Convert the value to a string
     *     (Implode the array values with commas)
     * 
     * @return string String value of the boolean
     */
    public function toString()
    {
        return implode(',', $this->value);
    }

    // ---- Array methods
    public function offsetExists($offset)
    {
        $value = $this->getValue();
        return (isset($value[$offset])) ? true : false;
    }
    public function offsetGet($offset)
    {
        $value = $this->getValue();
        if (isset($value[$offset])) {
            return $value[$offset];
        } else {
            trigger_error('Undefined index '.$offset, E_USER_NOTICE);
        }
    }
    public function offsetSet($offset,$value)
    {
        $current = $this->getValue();
        if (empty($offset)) {
            $current[] = $value;
        } else {
            $current[$offset] = $value;
        }
        $this->setValue($current);
    }
    public function offsetUnset($offset)
    {
        $value = $this->getValue();
        if (isset($value[$offset])) {
            unset($value[$offset]);
            $this->setValue($value);
        }
    }
    // ---- end Array methods

    // ---- Iterator methods
    public function rewind()
    {
        $this->index = 0;
    }
    public function current()
    {
        $value = $this->getValue();
        if (count($value) > $this->index) {
            $values = array_values(array_slice($value, $this->index, 1));
            return array_shift($values);
        } else {
            return false;
        }
    }
    public function key()
    {
        $value = $this->getValue();
        $keys  = array_keys(array_slice($value, $this->index, 1, true));
        return array_shift($keys);
    }
    public function next()
    {
        $this->index = $this->index+1;
        $value = $this->getValue();
        return array_slice($value,$this->index,1);
    }
    public function valid()
    {
        return $this->current() !== false;   
    }
    // ---- end Iterator methods
    
    public function count()
    {
        return count($this->getValue());
    }
    
}

?>