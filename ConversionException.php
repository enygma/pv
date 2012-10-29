<?php

namespace Pv;

class ConversionException extends \Exception
{
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

?>