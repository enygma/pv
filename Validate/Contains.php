<?php

namespace Pv\Validate;

class Contains extends \Pv\Validate\Validate
{
    public function __construct($value)
    {
        $this->setAllowedTypes(
            array('PString', 'PArray')
        );
        parent::__construct($value);
    }
    
    public function run()
    {
        $find = $this->getParam(0);

        if (is_array($this->value)) {
            return (in_array($find, $this->value))
                ? true : false;
        } else {
            return (strpos($this->value, $find) !== false)
                ? true : false;
        }
    }
}

?>