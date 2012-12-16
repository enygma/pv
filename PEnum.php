<?php

namespace Pv;

class PEnum extends Variable
{
    /**
     * Current object "properties"
     * @var array
     */
    private $properties = array();

    public function __construct($value, $type=null, $properties=null)
    {
        if ($properties !== null) {
            if (is_array($properties)) {
                $this->properties = $properties;
            }
        }

        if (!in_array($value, $this->properties)) {
            throw new \UnexpectedValueException('Could not create enum object, bad input');
        }

        parent::__construct($value, $type);
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