<?php

namespace Pv\Validate;

class Url extends \Pv\Validate\Validate
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
        return (filter_var($this->value, FILTER_VALIDATE_URL) !== false) 
            ? true : false;
    }
}

?>