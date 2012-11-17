<?php

namespace Pv;

class PNumber extends Variable
{
    public function __construct($value,$type=null)
    {
        if (!is_numeric($value)) {
            throw new ValidationException('Could not create numeric object, bad input');
        }

        parent::__construct($value,$type);
    }

    /**
     * Convert the value to a string
     * 
     * @return string String value of the boolean
     */
    public function toString()
    {
        return settype($this->value, 'string');
    }

}