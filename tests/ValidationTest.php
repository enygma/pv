<?php

class ValidationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Validate that the value is correctly set
     * 
     * @return null
     */
    public function testValueIsSet()
    {
        $valid = new \Pv\Validate\None(null);
        $valid->setValue('test');

        $this->assertEquals('test', $valid->getValue());
    }

    /**
     * Test that the params for the object are correctly set
     * 
     * @return null
     */
    public function testParamsAreSet()
    {
        $params = array('test' => 'foo');

        $valid = new \Pv\Validate\None(null);
        $valid->setParams($params);

        $this->assertEquals($params['test'], $valid->getParam('test'));
    }

    /**
     * Test that the default value is returned when the param doesn't exist
     * 
     * @return null
     */
    public function testParamReturnsDefault()
    {
        $params = array('test' => 'foo');

        $valid = new \Pv\Validate\None(null);
        $valid->setParams($params);

        $this->assertEquals('bar', $valid->getParam('foo', 'bar'));
    }

    /**
     * Test that a "single" call returns the current object (fluent interface)
     * 
     * @return null
     */
    public function testSingleValidationReturnsObject()
    {
        $valid = new \Pv\PString('me@me.com');
        $return = $valid->single('length[1,10]')->single('email');
        $this->assertEquals($return, $valid);
    }
}

?>