<?php

namespace Pv\Validate;

class Int extends \Pv\Validate\Validate
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
        return (is_integer($this->value) !== false) 
            ? true : false;
    }
}

?>