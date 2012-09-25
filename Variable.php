<?php

namespace Pv;

abstract class Variable
{
    protected $validate = array();
    protected $value    = null;

    public function __construct($value,$type=null)
    {
        $this->value = $value;
        $type = ($type == null) ? 'none' : $type;

        if (!is_array($type)) {
            $type = array($type);
        }
        foreach ($type as $t) {
            // see if we have parameters to pass
            $addlParams = array();
            if (strpos($t, '[') !== false) {
                preg_match('#(.+?)\[(.+?)\]#',$t,$params);
                $t = $params[1];
                $addlParams = explode(',',$params[2]);
            }
            $validation  = "\Pv\Validate\\".ucwords(strtolower($t));
            $valid = new $validation($value);
            if (!empty($addlParams)) {
                $valid->setParams($addlParams);
            }
            $this->validate[] = $valid;
        }
    }

    public function validate()
    {
        $pass = true;
        foreach ($this->validate as $index => $validate) {
            $ret = $validate->run();
            if ($ret == false) {
                $this->validate[$index]->fail();
                $pass = false;
            } else {
                $this->validate[$index]->pass();
            }
        }
        return $pass;
    }

    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        return $this->value = $value;
    }
    public function getValidation()
    {
        return $this->validate;
    }
}

?>