<?php

namespace Pv\Validate;

class Length extends \Pv\Validate\Validate
{
    public function run()
    {
        $minLength = $this->getParam(0);
        $maxLength = $this->getParam(1);

        if (is_array($this->value)) {
            if ($minLength !== null && count($this->value) < $minLength) {
                return false;
            }
            if ($maxLength !== null && count($this->value) > $maxLength) {
                return false;
            }
        } elseif (is_string($this->value)) {
            if ($minLength !== null && strlen($this->value) < $minLength) {
                return false;
            }
            if ($maxLength !== null && strlen($this->value) > $maxLength) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }
}

?>