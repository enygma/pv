<?php

class PArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that an exception is thrown when value is non-array
     * @expectedException \Pv\ValidationException
     */
    public function testValueIsCorrect()
    {
        $init  = 'test';
        $str   = new \Pv\PArray($init);
    }
}

?>