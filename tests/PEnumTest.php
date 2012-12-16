<?php

class PEnumTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that a corrent value is okay
     */
    public function testValueIsCorrect()
    {
        $init  = 'test';
        $set   = array('test');
        $str   = new \Pv\PEnum($init, null, $set);
    }

    /**
     * Test that a corrent value is bad
     * @expectedException \UnexpectedValueException
     */
    public function testValueIsInvalid()
    {
        $init  = 'foo';
        $set   = array('test');
        $str   = new \Pv\PEnum($init, null, $set);
    }
}

?>