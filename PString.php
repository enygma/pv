<?php

namespace Pv;

class PString extends Variable
{
    public function __construct($value,$type=null)
    {
        if (!is_string($value)) {
            throw new \Exception('Variable type mismatch, expected string');
        }
        parent::__construct($value,$type);
    }
}

?>