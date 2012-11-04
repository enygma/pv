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
        return date('r', $this->value);
    }

    /**
     * Return the string as a single value array
     * @return array
     */
    public function toArray()
    {
        return array($this->value);
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
        return $return;
    }

    /**
     * Return an object
     * @return \Pv\PObject
     */
    public function toObject()
    {
        $obj = new \stdClass();
        $obj->value = $this->value;
        return $obj;
    }
}

?>