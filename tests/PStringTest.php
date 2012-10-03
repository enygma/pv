<?php

class PStringTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that an exception is thrown when value is non-string
     * @expectedException \Pv\ValidationException
     */
    public function testValueIsCorrect()
    {
        $init  = true;
        $str   = new \Pv\PString($init);
    }
}

?>