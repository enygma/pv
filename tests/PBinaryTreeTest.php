<?php

class PBinaryTreeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that a valid tree is created when given several values
     * 
     * @return null
     */
    public function testCreateValidTree()
    {
        $tree = new \Pv\PBinaryTree();

        $tree->add(10);
        $tree->add(12);
        $tree->add(6);

        ob_start();
        $tree->dump();
        $data = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($data, "6\n10\n12\n");
    }
}

?>