<?php

class PBooleanTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that an exception is thrown when value is non-boolean
     * @expectedException \Pv\ValidationException
     */
    public function testValueIsCorrect()
    {
        $init  = 'test';
        $str   = new \Pv\PBoolean($init);
    }
}

?>