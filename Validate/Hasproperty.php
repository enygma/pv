<?php

namespace Pv\Validate;

class Hasproperty extends \Pv\Validate\Validate
{
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