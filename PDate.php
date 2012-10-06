<?php

namespace Pv;

class PDate extends Variable
{
    public function __construct($value,$type=null)
    {
        try {
            $dt = new \DateTime($value);    
        } catch(\Exception $e) {
            throw new ValidationException('Could not create date object, bad input');
        }
        
        parent::__construct($value,$type);
    }
}

?>