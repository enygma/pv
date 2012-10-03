<?php

class PObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that an exception is thrown when value is non-object
     * @expectedException \Pv\ValidationException
     */
    public function testValueIsCorrect()
    {
        $init  = true;
        $str   = new \Pv\PObject($init);
    }
}

?>