<?php

namespace Pv\Validate;

class Hasproperty extends \Pv\Validate\Validate
{
    public function __construct($value)
    {
        $this->setAllowedTypes(
            array('PObject')
        );
        parent::__construct($value);
    }

    public function run()
    {
        $property = $this->getParam(0);

        if (!is_object($this->value)) {
            return false;
        }
        return (isset($this->value->$property))
            ? true : false;
    }
}

?>