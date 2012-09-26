<?php

namespace Pv;

class PBoolean extends Variable
{
    public function __construct($value,$type=null)
    {
        if (!is_bool($value)) {
            throw new \Exception('Variable type mismatch, expected boolean');
        }
        parent::__construct($value,$type);
    }
}

?>