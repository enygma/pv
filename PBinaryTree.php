<?php

namespace Pv;

class PBinaryTree extends Variable
{
    /**
     * Base node of the tree
     * @var \Pv\PBinaryElement
     */
    private $base = null;

    /**
     * Value of the tree (not really used)
     * @var mixed
     */
    protected $value = null;

    /**
     * Create the binary tree object
     * 
     * @param mixed $value Value of tree (assigned, but not used)
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * Add a new value to the tree
     * 
     * @param mixed $data Data for new value
     */
    public function add($data)
    {
        if ($this->base !== null) {
            $this->base->add($data);
        } else {
            $this->base = new \Pv\PBinaryElement($data);
        }
    }

    /**
     * Find the element with the matching value
     * 
     * @param mixed   $find Value to find
     * @param integer $lvl  Tracking for nesting level
     * @return \Pv\PBinaryElement
     */
    public function get($find, $lvl = 1)
    {
        if ($find == $lvl) {
            return $this->base;
        } else {
            return $this->base->get($find, $lvl+1);
        }
    }

    /**
     * Dump out the contents of the tree
     * 
     * @return null
     */
    public function dump()
    {
        if ($this->base !== null) {
            $this->base->dump();
        }
    }
}

?>