<?php

namespace Pv\Validate;

class Numeric extends \Pv\Validate\Validate
{
    public function __construct($value)
    {
        $this->setAllowedTypes(
            array('PString')
        );
        parent::__construct($value);
    }

    public function run()
    {
        return (preg_match('#[0-9]+#', $this->value) !== false) 
            ? true : false;
    }
}

?>