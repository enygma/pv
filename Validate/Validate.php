<?php

namespace Pv\Validate;

abstract class Validate 
{
    protected $value  = null;
    protected $params = null;
    protected $status = true;

    public function __construct($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function setParams($params)
    {
        $this->params = $params;
    }
    public function getParam($index, $default=null)
    {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        } else {
            return ($default !== null) ? $default : null;
        }
    }
    public function fail()
    {
        $this->status = false;
    }
    public function pass()
    {
        $this->status = true;
    }

    public function run(){}
}

?>