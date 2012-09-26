<?php

class PStringTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }
    public function tearDown()
    {

    }

    public function testValueIsSet()
    {
        $init  = 'test';
        $str   = new \Pv\PString($init);
        $value = $str->getValue();

        $this->assertEquals($value,$init);
    }
}

?>