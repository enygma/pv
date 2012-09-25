<?php

namespace Pv\Validate;

class Range extends \Pv\Validate\Validate
{
    public function run()
    {
        $start = $this->getParam(0);
        $end   = $this->getParam(1);

        if (is_string($this->value) || is_numeric($this->value)) {
            $range = range($start,$end);
            return (in_array($this->value, $range))
                ? true : false;
        } else {
            return false;
        }
        return true;
    }
}

?>