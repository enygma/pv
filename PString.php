<?php

namespace Pv;

class PString extends Variable
{
    public function __construct($value,$type=null)
    {
        if (!is_string($value)) {
            throw new ValidationException('Variable type mismatch, expected string');
        }
        parent::__construct($value,$type);
    }

    /**
     * Convert to a DateTime object
     * @return \DateTime 
     */
    public function toDate()
    {
        return new \Pv\PDate($this->value);
    }

    /**
     * Return the string as a single value array
     * @return array
     */
    public function toArray()
    {
        return new \Pv\PArray($this->value);
    }

    /**
     * Convert to a boolean - if the value is "true" or "false"
     *   convert directly, otherwise set to true
     * @return bool
     */
    public function toBoolean()
    {
        $return = true;
        if ($this->value == 'true') {
            $return = true;
        }
        if ($this->value == 'false') {
            $return = false;
        }
        return new \Pv\PBoolean($return);
    }

    /**
     * Return an object
     * @return \Pv\PObject
     */
    public function toObject()
    {
        return new \Pv\PObject($this->value);
    }
}

?>