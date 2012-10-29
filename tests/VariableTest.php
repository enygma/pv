<?php

class VariableTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that the value set to the object is the same as was given
     */
    public function testValueIsSet()
    {
        $init  = 'test';
        $str   = new \Pv\PString($init);
        $value = $str->getValue();

        $this->assertEquals($value,$init);
    }

    /**
     * Test that the vailidation instances are correctly setup
     */
    public function testValidationSetup()
    {
        $init  = 'test';
        $str   = new \Pv\PString($init,array('length[1]'));
        $valid = $str->getValidation();

        $this->assertTrue($valid[0] instanceof \Pv\Validate\Length);
    }

    /**
     * Test that, when no validation is given, the object gets a "None" type
     */
    public function testNoValidationIsNone()
    {
        $str = new \Pv\PString('test');
        $valid = $str->getValidation();
        $this->assertTrue($valid[0] instanceof \Pv\Validate\None);
    }

    /**
     * Test that additional validation is correctly added
     */
    public function testAddAddlValidation()
    {
        $init  = 'test';
        $str   = new \Pv\PString($init,array('length[1]'));
        $str->addValidation('numeric');
        $valid = $str->getValidation();

        $this->assertEquals(count($valid),2);
        $this->assertTrue($valid[1] instanceof \Pv\Validate\Numeric);
    }

    /**
     * Test that, when a validation is set in the constructor with a name
     *     that it exists by that name
     */
    public function testValidationByKeynameConstruct()
    {
        $init = 'test';
        $str   = new \Pv\PString($init,array('test1' => 'length[1]'));

        $valid = $str->getValidation();
        $this->assertTrue(isset($valid['test1']));
    }

    /**
     * Test that, when set with the addValidation() call, the validation
     *     exists by the key name
     */
    public function testValidationByKeynameAddl()
    {
        $init = 'test';
        $str   = new \Pv\PString($init);
        $str->addValidation('length[1]','test1');

        $valid = $str->getValidation();
        $this->assertTrue(isset($valid['test1']));
    }

    /**
     * Execute only one validator from the two given, one that passes
     */
    public function testExecuteSingleValidatorPass()
    {
        $init = '123456789';
        $str   = new \Pv\PString($init, array('numeric','length[0,5]'));

        $result = $str->validate(0);
        $this->assertTrue($result);
    }

    /**
     * Execute only one validator from the two given, one that fails
     * @expectedException \Pv\ValidationException
     */
    public function testExecuteSingleValidatorFail()
    {
        $init = '123456789';
        $str   = new \Pv\PString($init, array('numeric','length[0,5]'));

        $result = $str->validate(1);
    }

    /**
     * Test that a conversion to an invalid type fails
     * @expectedException \Pv\ConversionException
     */
    public function testConvertInvalidType()
    {
        $init = true;
        $bool = new \Pv\PBoolean($init);

        $bool->convert('foo');
    }
}

?>
