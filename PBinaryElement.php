<?php

namespace Pv;

class PBinaryElement extends Variable
{
    /**
     * Current element's data
     * @var mixed
     */
    protected $value = null;

    /**
     * Previous element
     * @var \Pv\PBinaryElement
     */
    private $prev = null;

    /**
     * Next element
     * @var \Pv\PBinaryElement
     */
    private $next = null;

    /**
     * Create the element based on the value
     * 
     * @param mixed $value Value of the new element
     * @return null
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Add another value to the data set
     * 
     * @param mixed $value Item value
     * @return null
     */
    public function add($value)
    {
        if ($this->value < $value) {
            if ($this->next !== null) {
                $this->next->add($value);
            } else {
                $this->next = new \Pv\PBinaryElement($value);
            }
        } else {
            if ($this->prev !== null) {
                $this->prev->add($value);
            } else {
                $this->prev = new \Pv\PBinaryElement($value);
            }
        }
    }

    /**
     * Output the contents of the current and prev/next elements
     * 
     * @return null
     */
    public function dump()
    {
        if ($this->prev !== null) {
            $this->prev->dump();
        }
        
        echo print_r($this->value, true) . "\n";

        if ($this->next !== null) {
            $this->next->dump();
        }
    }

    public function get($find, $lvl)
    {
        if ($find == $lvl) {
            return $this;
        } else {
            return $this->next->get($find, $lvl++);
        }
    }
}

?>