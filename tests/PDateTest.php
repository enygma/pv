<?php

class PDateTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that an exception is thrown when value isn't parseable
     * @expectedException \Pv\ValidationException
     */
    public function testValueIsCorrect()
    {
        $init  = 'bad date value';
        $str   = new \Pv\PDate($init);
    }
}

?>