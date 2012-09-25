<?php

namespace Pv\Validate;

class Int extends \Pv\Validate\Validate
{
    public function run()
    {
        return (is_integer($this->value) !== false) 
            ? true : false;
    }
}

?>