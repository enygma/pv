<?php

namespace Pv;

class PObject extends Variable
{
    public function __construct($value,$type=null)
    {
        if (!is_object($value)) {
            throw new ValidationException('Variable type mismatch, expected object');
        }
        parent::__construct($value,$type);
    }

    /**
     * Return a serialized version of the object
     * @return string
     */
    public function toString()
    {
        return serialize($this->value);
    }
}

?>