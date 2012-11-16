<?php

namespace Pv\Validate;

class Instance extends \Pv\Validate\Validate
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
        $class = $this->getParam(0);

        if (!is_object($this->value)) {
            return false;
        } else {
            return ($this->value instanceof $class)
                ? true : false;
        }
    }
}

?>