<?php

class PArrayTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }
    public function tearDown()
    {

    }

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