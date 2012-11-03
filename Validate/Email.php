<?php

namespace Pv\Validate;

class Email extends \Pv\Validate\Validate
{
    public function run()
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }
}

?>