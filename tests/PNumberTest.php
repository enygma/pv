<?php

class PNumberTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that an exception is thrown when value is not numeric
     * @expectedException \Pv\ValidationException
     */
    public function testValueIsString()
    {
        $init = 'testing';
        $num  = new \Pv\PNumber($init);
    }

    /**
     * Validate that, when a valid numeric value is given, the object
     *     is created correctly
     */
    public function testValueIsNumeric()
    {
        $init = 12345;
        $num  = new \Pv\PNumber($init);
        $this->assertTrue($num instanceof \Pv\PNumber);
    }
}

?>