<?php

namespace Pv;

abstract class Variable
{
    protected $validate = array();
    protected $value    = null;
    protected $negate   = false;

    public function __construct($value,$type=null)
    {
        $this->value = $value;
        $type = ($type == null) ? 'none' : $type;

        $this->setupValidation($type);
    }

    /**
     * Set up the validation objects for the variable
     * 
     * @param mixed $type Either string/array of validation options
     * @return null
     */
    private function setupValidation($type)
    {
        if (!is_array($type)) {
            $type = array($type);
        }
        foreach ($type as $index => $t) {
            $negate = false;

            // see if we have a "not:" to negate
            if (strpos($t, 'not:') !== false) {
                $t = str_replace('not:','',$t);
                $negate = true;
            }

            // see if we have parameters to pass
            $addlParams = array();
            if (strpos($t, '[') !== false) {
                preg_match('#(.+?)\[(.+?)\]#',$t,$params);
                $t = $params[1];
                $addlParams = explode(',',$params[2]);
            }
            $validation  = "\Pv\Validate\\".ucwords(strtolower($t));
            $valid = new $validation($this->value);
            if (!empty($addlParams)) {
                $valid->setParams($addlParams);
            }
            if ($negate == true) {
                $valid->negate();
            }

            // get the current validation and append
            $currentValidation = $this->getValidation();
            $newValidation = array_merge($currentValidation,array($index => $valid));
            $this->validate = $newValidation;
        }
    }

    /**
     * Execute the validation on the variable's current value
     * 
     * @return boolean $pass Pass/fail result from validation
     */
    public function validate()
    {
        $pass = true;
        foreach ($this->validate as $index => $validate) {
            $ret   = $validate->run();
            $check = false;

            // see if we need to negate the check
            if ($validate->isNegated() == true) {
                $check = true;
            }

            if ($ret == $check) {
                $this->validate[$index]->fail();
                $pass = false;
                $msg = 'Failure on validation '.get_class($validate);
                if ($validate->isNegated()) {
                    $msg .= ' (negated)';
                }
                throw new ValidationException($msg);
            } else {
                $this->validate[$index]->pass();
            }
        }
        return $pass;
    }

    /**
     * Get the current variable's value
     * 
     * @return mixed Variable value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value for the variable
     * 
     * @param mixed $value Variable value
     */
    public function setValue($value)
    {
        return $this->value = $value;
    }

    /**
     * Return the current set of validation methods
     * 
     * @return array Set of validation objects
     */
    public function getValidation()
    {
        return $this->validate;
    }

    /**
     * Add additional validation options to the variable
     * 
     * @param mixed $types Either a string/array of types to add & options
     */
    public function addValidation($types, $name=null)
    {
        if (!is_array($types)) {
            $types = ($name !== null)
                ? array($name => $types) : array($types);
        }
        $this->setupValidation($types);
    }

    /**
     * Remove validation from an object
     * 
     * @param mixed $index Integer/string key for the validation to remove
     * @return boolean Pass/fail on removal
     */
    public function removeValidation($index)
    {
        if (isset($this->validate[$index])) {
            unset($this->validate[$index]);
            return true;
        } else {
            return false;
        }
    }
}

?>
