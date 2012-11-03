<?php

namespace Pv;

class PDate extends Variable
{
    public function __construct($value,$type=null)
    {
        try {
            $value = new \DateTime($value);    
        } catch(\Exception $e) {
            throw new ValidationException('Could not create date object, bad input');
        }
        
        parent::__construct($value,$type);
    }

    /**
     * Convert the DateTime object to a string RFC-2822 string
     * @return string
     */
    public function toString()
    {
        return date('r', $this->value);
    }
}

?>