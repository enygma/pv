<?php

namespace Pv;

abstract class Variable
{
    /**
     * Object validation methods
     * @var array
     */
    protected $validate = array();

    /**
     * Object's current value
     * @var mixed
     */
    protected $value    = null;

    /**
     * Negate the evaluation or not
     * @var boolean
     */
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
     * 
     * @return null
     */
    private function setupValidation($type)
    {
        if (!is_array($type)) {
            $type = array($type);
        }
        foreach ($type as $index => $t) {
            $negate = false;

            if ($t instanceof \Closure) {
                $valid = $t($this->value);

            } else {
                // see if we have a "not:" to negate
                if (strpos($t, 'not:') !== false) {
                    $t = str_replace('not:', '', $t);
                    $negate = true;
                }

                // see if we have parameters to pass
                $addlParams = array();
                if (strpos($t, '[') !== false) {
                    preg_match('#(.+?)\[(.+?)\]#', $t, $params);
                    $t = $params[1];
                    $addlParams = explode(',', $params[2]);
                }
                $validation  = "\Pv\Validate\\".ucwords(strtolower($t));
                $valid = new $validation($this->value);

                if (!empty($addlParams)) {
                    $valid->setParams($addlParams);
                }
                if ($negate == true) {
                    $valid->negate();
                }    
            }

            if (strtolower($t) == 'none' || $valid->isAllowedType(get_class($this)) == true) {
                $this->appendValidation($index, $valid);
            }
        }
    }

    /**
     * Append the validation to the validation set
     * 
     * @param string $index Index (name) for the validation
     * @param mixed $valid A Validation object (extends \Pv\Validate)
     * 
     * @return null
     */
    public function appendValidation($index, $valid)
    {
        // get the current validation and append
        $currentValidation = $this->getValidation();
        $newValidation = array_merge(
            $currentValidation, 
            array($index => $valid)
        );
        $this->validate = $newValidation;
    }

    /**
     * Execute the validation on the variable's current value
     * 
     * @param mixed $index Eithe name or ID of validtor to execute
     * 
     * @return boolean $pass Pass/fail result from validation
     */
    public function validate($index=null)
    {
        $pass = true;

        // see if we're just trying to run one validator
        if ($index !== null && isset($this->validate[$index])) {
            $this->execValidation($this->validate[$index], $index);
        } else {
            foreach ($this->validate as $index => $validate) {
                $this->execValidation($validate, $index);
            }
        }
        return $pass;
    }

    /**
     * Execute the validator
     * 
     * @param object $validate Validator object (either \Pv\Validate\Validate or a \Closure)
     * @param string $index    Validator index (in validation set)
     * 
     * @throws Exception Validation failure
     * 
     * @return null
     */
    public function execValidation($validate, $index)
    {
        if (is_bool($validate)) {
            $this->execValidatorClosure($validate, $index);
        } else {
            $this->execValidatorObject($validate, $index);
        }
    }

    /**
     * Validate a normal \Pv\Validate\Validate object
     * 
     * @param \Pv\Validate\Validate $validate Validation object
     * @param mixed $index Index of the validator
     * 
     * @return null
     */
    private function execValidatorObject($validate, $index)
    {
        $ret   = $validate->run();
        $check = false;
        if ($validate->isNegated() == true) {
            $check = true;
        }

        if ($ret == $check) {
            $pass = false;
            $this->validate[$index]->fail();
            $msg = 'Failure on validation '.get_class($validate);
            if ($validate->isNegated()) {
                $msg .= ' (negated)';
            }
            throw new ValidationException($msg);
        } else {
            $this->validate[$index]->pass();
        }
    }

    /**
     * Execute a validation closure
     * 
     * @param boolean $validate Result of validation closure execution
     * @param mixed   $index    Index of the validator in the set
     * 
     * @return null
     */
    private function execValidatorClosure($validate, $index)
    {
        if ($validate == false) {
            throw new ValidationException(
                'Failure on validation Closure at index '.$index
            );
        }
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
     * 
     * @return boolean If value was set correctly
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
     * @param mixed  $types Either a string/array of types to add & options
     * @param string $name  Optional name for the validator
     * 
     * @return null;
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
     * 
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

    /**
     * Convert the object to the given type
     * 
     * @param string $type Type to convert to
     * 
     * @return an object of the new type
     */
    public function convert($type)
    {
        // see if we have an object of that type
        $toType = ucwords(strtolower($type));
        $file   = __DIR__.'/P'.$type.'.php';

        if (is_file($file)) {
            // see if we have the conversion method
            $method = 'to'.ucwords(strtolower($type));
            if (method_exists($this, $method)) {

                // try to make an object
                $objectType = '\Pv\P'.$type;
                $obj = new $objectType($this->$method());

                // filter through the validations on the object and be sure 
                // they can stick around
                foreach ($this->getValidation() as $index => $valid) {

                    // can it go on the new object?
                    if ($valid->isAllowedType('P'.$type) == true){
                        $obj->appendValidation($index, $valid);
                    }
                }

                return $obj;
            } else {
                throw new \Pv\ConversionException(
                    'Cannot convert to type "'.$type.'"'
                );
            }
        } else {
            throw new \Pv\ConversionException('Invalid conversion type "'.$type.'"');
        }
    }
}

?>
