<?php

namespace Pv\Validate;

abstract class Validate 
{
    /**
     * Current value (usually from Variable)
     * @var mixed
     */
    protected $value  = null;

    /**
     * Parameters for the Validation
     * @var array
     */
    protected $params = null;

    /**
     * Status of the validation
     * @var boolean
     */
    protected $status = true;

    /**
     * Flag for negation
     * @var boolean
     */
    protected $negate = false;

    /**
     * Object types this validation is allowed on
     * @var array
     */
    protected $allowedTypes = array();

    /**
     * Init the object
     * 
     * @param mixed $value Value coming from the Variable
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the current value set
     * 
     * @return mixed Current value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set teh value for the validation (usually from the Variable)
     * 
     * @param mixed $value Value for object
     * 
     * @return null
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Set the params for the current instance
     * 
     * @param mixed $params Parameters to set
     * 
     * @return null
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Get a parameter value for the index given
     * 
     * @param string $index   Index of param to locate
     * @param mixed  $default Default value to return if none is found
     * 
     * @return moxed Either the param value or a default/null
     */
    public function getParam($index, $default=null)
    {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        } else {
            return ($default !== null) ? $default : null;
        }
    }

    /**
     * Set the types allowed for the validation
     * 
     * @param mixed $types Either a string or array of object types
     */
    public function setAllowedTypes($types)
    {
        $types = (!is_array($types)) ? array($types) : $types;
        foreach ($types as $type) {
            $this->allowedTypes[] = strtolower($type);
        }
    }

    /**
     * Get the full list of allowed object types
     * 
     * @return array Allowed types list
     */
    public function getAllowedTypes()
    {
        return $this->allowedTypes;
    }

    /**
     * See if a type is allowed for this object
     * 
     * @param string $type Object type
     * 
     * @return boolean Allowed/not allowed
     */
    public function isAllowedType($type)
    {
        $type = str_replace('Pv\\','',$type);
        return (in_array(strtolower($type), $this->allowedTypes)) ? true : false;
    }

    /**
     * Fail this validation manually
     * 
     * @return null
     */
    public function fail()
    {
        $this->status = false;
    }

    /**
     * Pass this validation manually
     * 
     * @return null
     */
    public function pass()
    {
        $this->status = true;
    }

    /**
     * Negate the check (a "not")
     * 
     * @return null
     */
    public function negate()
    {
        $this->negate = true;
    }

    /**
     * Check to see if the validation should be treated as "negated"
     * 
     * @return boolean If negated, return true (is negated), otherwise false
     */
    public function isNegated()
    {
        return ($this->negate == true) ? true : false;
    }

    /**
     * Stub for run() method in children
     * 
     * @return null
     */
    public function run(){}
}

?>