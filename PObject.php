<?php

namespace Pv;

class PObject extends Variable
{
    public function __construct($value,$type=null)
    {
        if (!is_object($value)) {
            throw new \Exception('Variable type mismatch, expected object');
        }
        parent::__construct($value,$type);
    }
}

?>