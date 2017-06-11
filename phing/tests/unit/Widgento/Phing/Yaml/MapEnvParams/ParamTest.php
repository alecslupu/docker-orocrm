<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 6/11/17
 * Time: 10:48 PM
 */

namespace tests\unit\Widgento\Phing\Yaml\MapEnvParams;

use Widgento\Phing\Yaml\MapEnvParams\Param;

class ParamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Param
     */
    private $param;

    public function setUp()
    {
        $this->param = new Param();
    }

    public function testName()
    {
        $name = 'some name';
        $this->assertNull($this->param->getName());
        $this->assertSame($this->param, $this->param->setName($name));
        $this->assertEquals($name, $this->param->getName());
    }

    public function testValue()
    {
        $value = 'some value';
        $this->assertNull($this->param->getValue());
        $this->assertSame($this->param, $this->param->setValue($value));
        $this->assertEquals($value, $this->param->getValue());
    }
}