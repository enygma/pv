<?php

class VariableTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }
    public function tearDown()
    {

    }

    public function testValueIsObject()
    {
        $str   = new \Pv\String('test');
        $value = $str->getValue();

        $this->assertTrue($value instanceof \Pv\Validate\Validate);
    }
}

?>