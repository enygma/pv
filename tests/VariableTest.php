<?php

class VariableTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }
    public function tearDown()
    {

    }

    public function testValidationSetup()
    {
        $init  = 'test';
        $str   = new \Pv\PString($init,array('length[1]'));
        $valid = $str->getValidation();

        $this->assertTrue($valid[0] instanceof \Pv\Validate\Length);
    }

    public function testAddAddlValidation()
    {
        $init  = 'test';
        $str   = new \Pv\PString($init,array('length[1]'));
        $str->addValidation('numeric');
        $valid = $str->getValidation();

        $this->assertEquals(count($valid),2);
        $this->assertTrue($valid[1] instanceof \Pv\Validate\Numeric);
    }
}

?>
